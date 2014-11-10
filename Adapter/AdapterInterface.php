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

use CL\Tissue\Model\ScanResult;

interface AdapterInterface
{
    /**
     * @param string|array $paths
     * @param array        $options
     *
     * @return ScanResult
     */
    public function scan($paths, array $options = []);
}
