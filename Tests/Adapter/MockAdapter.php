<?php

/*
 * This file is part of the Tissue library.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CL\Tissue\Tests\Adapter;

use CL\Tissue\Adapter\AbstractAdapter;
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

        $detections = [];
        foreach ($files as $path) {
            if (stristr($path, 'virus') || stristr(file_get_contents($path), 'EICAR')) {
                $detections[] = $path;
            }
        }

        return new ScanResult($paths, $files, $detections);
    }
}
