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

use CL\Tissue\Model\Detection;
use Symfony\Component\Process\ProcessBuilder;

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @param string      $path
     * @param int         $type
     * @param string|null $description
     *
     * @return Detection
     */
    protected function createDetection($path, $type = Detection::TYPE_VIRUS, $description = null)
    {
        $detection = new Detection($path, $type, $description);

        return $detection;
    }

    /**
     * Creates a new process builder that your might use to interact with your virus-scanner's executable
     *
     * @param array    $arguments An optional array of arguments
     * @param int|null $timeout   An optional number of seconds for the process' timeout limit
     *
     * @return ProcessBuilder A new process builder
     *
     * @codeCoverageIgnore
     */
    protected function createProcessBuilder(array $arguments = [], $timeout = null)
    {
        $pb = new ProcessBuilder($arguments);

        if (null !== $timeout) {
            $pb->setTimeout($timeout);
        }

        return $pb;
    }
}
