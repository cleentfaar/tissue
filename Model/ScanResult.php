<?php

/*
 * This file is part of the Tissue library.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CL\Tissue\Model;

class ScanResult
{
    /**
     * @var array
     */
    protected $paths;

    /**
     * @var array
     */
    protected $files;

    /**
     * @var Detection[]
     */
    protected $detections;

    /**
     * @param array       $pathsScanned
     * @param array       $filesScanned
     * @param Detection[] $detectionsFound
     */
    public function __construct(array $pathsScanned, array $filesScanned, array $detectionsFound)
    {
        $this->paths      = $pathsScanned;
        $this->files      = $filesScanned;
        $this->detections = $detectionsFound;
    }

    /**
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return Detection[]
     */
    public function getDetections()
    {
        return $this->detections;
    }

    /**
     * @return bool
     */
    public function hasVirus()
    {
        return count($this->getDetections()) > 0;
    }
}
