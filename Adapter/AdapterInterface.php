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
     * Set the process timeout.
     *
     * @param int|null $timeout The timeout for the process
     */
    public function setTimeout($timeout);

    /**
     * Gets the process timeout.
     *
     * @return int|null The timeout for the process
     */
    public function getTimeout();

    /**
     * @param string|array $path
     * @param array        $options
     *
     * @return ScanResult
     */
    public function scan($path, array $options = []);
}
