<?php

namespace CL\Tissue\Adapter;

use CL\Tissue\Exception\AdapterException;
use CL\Tissue\Model\Detection;
use Symfony\Component\Process\Process;

class ClamAVAdapter extends AbstractAdapter
{
    /**
     * @var string
     */
    protected $clamScanPath;

    /**
     * @var string
     */
    protected $databasePath;

    /**
     * @param string      $clamScanPath
     * @param string|null $databasePath
     *
     * @throws AdapterException If the given path to clamscan (or clamdscan) is not executable
     */
    public function __construct($clamScanPath, $databasePath = null)
    {
        if (!is_executable($clamScanPath)) {
            throw new AdapterException(sprintf(
                'The path to `clamscan` or `clamdscan` could not be found or is not executable (path: %s)',
                $clamScanPath
            ));
        }

        $this->clamScanPath = $clamScanPath;
        $this->databasePath = $databasePath;
    }

    /**
     * {@inheritdoc}
     */
    protected function detect($path)
    {
        if (!is_string($path)) {
            throw new AdapterException(sprintf(
                'You must supply an array of strings (paths) to scan: path with type "%s" given',
                gettype($path)
            ));
        }

        $process    = $this->createProcess($path);
        $returnCode = $process->run();
        $output     = trim($process->getOutput());
        if (0 !== $returnCode && !strstr($output, ' FOUND')) {
            throw AdapterException::fromProcess($process);
        }

        foreach (explode("\n", $output) as $line) {
            if (substr($line, -6) === ' FOUND') {
                $file = substr($line, 0, strripos($line, ':'));
                $description = substr(substr($line, strripos($line, ':') + 2), 0, -6);

                return $this->createDetection($file, Detection::TYPE_VIRUS, $description);
            }
        }
    }

    /**
     * @param string $path
     *
     * @return Process
     */
    private function createProcess($path)
    {
        $pb = $this->createProcessBuilder([$this->clamScanPath]);
        $pb->add('--no-summary');

        if ($this->usesDaemon($this->clamScanPath)) {
            // Pass filedescriptor to clamd (useful if clamd is running as a different user)
            $pb->add('--fdpass');
        } elseif ($this->databasePath !== null) {
            // Only the (isolated) binary version can change the signature-database used
            $pb->add(sprintf('--database=%s', $this->databasePath));
        }

        $pb->add($path);

        return $pb->getProcess();
    }

    /**
     * @return bool
     */
    private function usesDaemon($path)
    {
        return substr($path, -9) === 'clamdscan';
    }
}
