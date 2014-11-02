<?php

namespace CL\Tissue\Adapter;

use CL\Tissue\Model\ScanResult;

class MockAdapter extends AbstractAdapter
{
    /**
     * {@inheritdoc}
     */
    public function scan($paths, array $options = [])
    {
        if (!is_array($paths)) {
            $files = [$paths];
        } else {
            $files = $paths;
        }

        return new ScanResult($paths, $files, []);
    }
}
