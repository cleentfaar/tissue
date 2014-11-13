<?php

/*
 * This file is part of the Tissue library.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CL\Tissue\Tests\Model;

use CL\Tissue\Model\ScanResult;

class ScanResultTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFiles()
    {
        $path  = 'foobar1.txt';
        $files = [
            'foobar1.txt',
        ];

        $scanResult  = new ScanResult([$path], $files, []);
        $actualFiles = $scanResult->getFiles();

        $this->assertEquals($files, $actualFiles);
    }

    public function testGetDetections()
    {
        $path       = 'foobar1.txt';
        $files      = [
            'foobar1.txt',
        ];
        $detections = $files;

        $scanResult = new ScanResult([$path], $files, $detections);
        $this->assertEquals($detections, $scanResult->getDetections());
        $this->assertTrue($scanResult->hasVirus());
    }
}
