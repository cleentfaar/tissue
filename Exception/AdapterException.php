<?php

/*
 * This file is part of the Tissue library.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CL\Tissue\Exception;

use Symfony\Component\Process\Process;

class AdapterException extends \RuntimeException
{
    /**
     * @var string
     */
    private $originalMessage;

    /**
     * @param string     $message
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->originalMessage = $message;
    }

    /**
     * @param Process $process
     *
     * @return AdapterException
     */
    public static function fromProcess(Process $process)
    {
        $message = sprintf("An error occurred while running:\n%s", $process->getCommandLine());
        $errorOutput = $process->getErrorOutput();
        if (!empty($errorOutput)) {
            $message .= "\n\nError Output:\n" . str_replace("\r", '', $errorOutput);
        }

        $output = $process->getOutput();
        if (!empty($output)) {
            $message .= "\n\nOutput:\n" . str_replace("\r", '', $output);
        }

        return new self($message);
    }
}
