<?php

namespace CL\Tissue\Adapter;

use CL\Tissue\Model\Detection;
use CL\Tissue\Model\ScanResult;
use Symfony\Component\Process\ProcessBuilder;

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var int|null
     */
    protected $timeout;

    /**
     * {@inheritdoc}
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param array $paths
     * @param array $options
     *
     * @return ScanResult
     */
    protected function scanArray(array $paths, array $options)
    {
        $files = [];
        $detections = [];
        $scannedPaths = [];
        foreach ($paths as $path) {
            $result = $this->scan($path, $options);
            $files = array_merge($result->getFiles(), $files);
            $detections = array_merge($result->getDetections(), $detections);
            $scannedPaths[] = $path;
        }

        return new ScanResult($scannedPaths, $files, $detections);
    }

    /**
     * @param $path
     * @param int $type
     * @param null $description
     *
     * @return Detection
     */
    protected function createDetection($path, $type = Detection::TYPE_VIRUS, $description = null)
    {
        $detection = new Detection($path, $type, $description);

        return $detection;
    }

    /**
     * Creates a new process builder.
     *
     * @param array $arguments An optional array of arguments
     *
     * @return ProcessBuilder A new process builder
     *
     * @codeCoverageIgnore
     */
    protected function createProcessBuilder(array $arguments = [])
    {
        $pb = new ProcessBuilder($arguments);

        if (null !== $this->timeout) {
            $pb->setTimeout($this->timeout);
        }

        return $pb;
    }
}
