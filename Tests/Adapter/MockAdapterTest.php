<?php

namespace CL\Tissue\Tests\Adapter;

use CL\Tissue\Adapter\MockAdapter;

class MockAdapterTest extends AbstractAdapterTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createAdapter()
    {
        return new MockAdapter();
    }

    public function testEicarDetection()
    {
        //$this->markTestSkipped('Mock adapter has no way of detecting an EICAR infection');
    }
}
