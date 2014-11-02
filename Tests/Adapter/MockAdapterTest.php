<?php

namespace CL\Tissue\Tests\Adapter;

use CL\Tissue\Model\ScanResult;

class MockAdapterTest extends AdapterTestCase
{
    /**
     * @var MockAdapter
     */
    private $adapter;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->adapter = new MockAdapter();
    }

    /**
     * Tests the setting and getting of the internal process' timeout value
     */
    public function testSetGetTimeout()
    {
        $this->adapter->setTimeout(10);
        $this->assertEquals(10, $this->adapter->getTimeout());
    }

    /**
     * Tests calling scan() with a single path
     */
    public function testScanSingle()
    {
        $path = 'foobar.txt';
        $scanResult = new ScanResult($path, [$path], []);

        $actualResult = $this->adapter->scan($path);
        $this->assertEquals($scanResult, $actualResult);
        $this->assertCount(1, $actualResult->getFiles());
        $this->assertCount(0, $actualResult->getDetections());
    }

    /**
     * Tests calling scan() with an array of paths
     */
    public function testScanMultiple()
    {
        $paths = ['foobar1.txt', 'foobar2.txt'];
        $scanResult = new ScanResult($paths, $paths, []);

        $actualResult = $this->adapter->scan($paths);
        $this->assertEquals($scanResult, $actualResult);
        $this->assertCount(2, $actualResult->getFiles());
        $this->assertCount(0, $actualResult->getDetections());
    }
}
