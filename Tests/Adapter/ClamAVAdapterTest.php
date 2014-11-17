<?php

namespace CL\Tissue\Tests\Adapter;

use CL\Tissue\Adapter\ClamAVAdapter;

class ClamAVAdapterTest extends AbstractAdapterTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createAdapter()
    {
        if (!$clamScanPath = $this->findExecutable('clamscan', 'CLAMSCAN_BIN')) {
            $this->markTestSkipped('Unable to locate `clamscan` executable.');
        }

        return new ClamAVAdapter($clamScanPath);
    }

    /**
     * @expectedException \CL\Tissue\Exception\AdapterException
     * @expectedExceptionMessage The path to `clamscan` or `clamdscan` could not be found or is not executable
     */
    public function testInvalidClamScanPath()
    {
        new ClamAVAdapter('/path/to/non-existing/binary');
    }
}
