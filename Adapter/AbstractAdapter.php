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
use Symfony\Component\Process\ProcessBuilder;

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public function scan($paths, array $options = [])
    {
        if (is_array($paths)) {
            return $this->scanArray($paths, $options);
        }

        $files      = [];
        $detections = [];
        $path       = realpath($paths);

        if (!$path) {
            throw new \InvalidArgumentException(sprintf('File to scan does not exist: %s', $path));
        }

        if (is_dir($path)) {
            $paths = [$paths];
            return $this->scanDir($path, $options, $paths, $files, $detections);
        } else {
            $files[] = $path;
            if ($detection = $this->detect($path)) {
                $detections[] = $detection;
            }

            return new ScanResult([$path], $files, $detections);
        }
    }

    /**
     * @param array $paths
     * @param array $options
     *
     * @return ScanResult
     */
    public function scanArray(array $paths, array $options = [])
    {
        $files      = [];
        $detections = [];

        foreach ($paths as $path) {
            $result     = $this->scan($path, $options);
            $paths      = array_merge($paths, $result->getPaths());
            $files      = array_merge($files, $result->getFiles());
            $detections = array_merge($detections, $result->getDetections());
        }

        return new ScanResult($paths, $files, $detections);
    }

    /**
     * @param string $dir
     * @param array  $options
     * @param array  $currentPaths
     * @param array  $currentFiles
     * @param array  $currentDetections
     *
     * @return ScanResult
     */
    protected function scanDir($dir, array $options, array &$currentPaths = [], array &$currentFiles = [], array &$currentDetections = [])
    {
        $fileinfos = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
        $files     = [];
        foreach ($fileinfos as $pathname => $fileinfo) {
            if (!$fileinfo->isFile()) {
                continue;
            }

            $files[] = $pathname;
        }

        $result            = $this->scanArray($files, $options);
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
     * @param string $path
     *
     * @return ScanResult
     */
    abstract protected function detect($path);
}
