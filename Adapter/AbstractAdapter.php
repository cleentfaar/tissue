<?php

/*
 * This file is part of the Tissue library.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CL\Tissue\Adapter;

use CL\Tissue\Model\Detection;
use CL\Tissue\Model\ScanResult;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Process\ProcessBuilder;

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var OptionsResolverInterface|null
     */
    private $resolver;

    /**
     * {@inheritdoc}
     */
    public function scan(array $paths, array $options = [])
    {
        $this->options = $this->resolveOptions($options);

        return $this->scanArray($paths);
    }

    /**
     * @param array $paths
     *
     * @return ScanResult
     */
    protected function scanArray(array $paths)
    {
        $files         = [];
        $detections    = [];

        foreach ($paths as $path) {
            $result     = $this->scanSingle($path, $this->options);
            $paths      = array_merge($paths, $result->getPaths());
            $files      = array_merge($files, $result->getFiles());
            $detections = array_merge($detections, $result->getDetections());
        }

        return new ScanResult($paths, $files, $detections);
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function resolveOptions(array $options)
    {
        if ($this->resolver === null) {
            $resolver = new OptionsResolver();
            $this->configureOptions($resolver);
        }

        return $this->resolver->resolve($options);
    }

    /**
     * @param string $path
     *
     * @return ScanResult
     */
    protected function scanSingle($path)
    {
        $files      = [];
        $detections = [];
        $path       = realpath($path);

        if (!$path) {
            throw new \InvalidArgumentException(sprintf('File to scan does not exist: %s', $path));
        }

        if (is_dir($path)) {
            $paths = [$path];

            return $this->scanDir($path, $paths, $files, $detections);
        } else {
            $files[] = $path;
            if ($detection = $this->detect($path)) {
                $detections[] = $detection;
            }

            return new ScanResult([$path], $files, $detections);
        }
    }

    /**
     * @param string $dir
     * @param array  $currentPaths
     * @param array  $currentFiles
     * @param array  $currentDetections
     *
     * @return ScanResult
     */
    protected function scanDir($dir, array &$currentPaths = [], array &$currentFiles = [], array &$currentDetections = [])
    {
        $fileinfos = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
        $files     = [];
        foreach ($fileinfos as $pathname => $fileinfo) {
            if (!$fileinfo->isFile()) {
                continue;
            }

            $files[] = $pathname;
        }

        $result            = $this->scanArray($files);
        $currentPaths      = array_merge($currentPaths, $result->getPaths());
        $currentFiles      = array_merge($currentFiles, $result->getFiles());
        $currentDetections = array_merge($currentDetections, $result->getDetections());
    }

    /**
     * @param string      $path
     * @param int         $type
     * @param string|null $description
     *
     * @return Detection
     */
    protected function createDetection($path, $type = Detection::TYPE_VIRUS, $description = null)
    {
        $detection = new Detection($path, $type, $description);

        return $detection;
    }

    /**
     * Creates a new process builder that your might use to interact with your virus-scanner's executable
     *
     * @param array    $arguments An optional array of arguments
     * @param int|null $timeout   An optional number of seconds for the process' timeout limit
     *
     * @return ProcessBuilder A new process builder
     *
     * @codeCoverageIgnore
     */
    protected function createProcessBuilder(array $arguments = [], $timeout = null)
    {
        $pb = new ProcessBuilder($arguments);

        if (null !== $timeout) {
            $pb->setTimeout($timeout);
        }

        return $pb;
    }

    /**
     * @param OptionsResolverInterface $optionsResolver
     */
    abstract protected function configureOptions(OptionsResolverInterface $optionsResolver);

    /**
     * @param string $path
     *
     * @return Detection|null
     */
    abstract protected function detect($path);
}
