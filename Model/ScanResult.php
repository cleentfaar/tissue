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
     * @var string|array
     */
    protected $pathScanned;

    /**
     * @var array
     */
    protected $files;

    /**
     * @var Detection[]
     */
    protected $detections;

    /**
     * @param string|array $pathScanned
     * @param array        $files
     * @param Detection[]  $detections
     */
    public function __construct($pathScanned, array $files, array $detections)
    {
        $this->pathScanned = $pathScanned;
        $this->files       = $files;
        $this->detections  = $detections;
    }

    /**
     * @return bool
     */
    public function hasVirus()
    {
        return count($this->getDetections()) > 0;
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
}
