<?php

namespace CL\Tissue\Adapter;

use Symfony\Component\Process\ProcessBuilder;

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var int|null
     */
    protected $timeout;

    /**
     * {@inheritdoc}
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Creates a new process builder.
     *
     * @param array $arguments An optional array of arguments
     *
     * @return ProcessBuilder A new process builder
     *
     * @codeCoverageIgnore
     */
    protected function createProcessBuilder(array $arguments = [])
    {
        $pb = new ProcessBuilder($arguments);

        if (null !== $this->timeout) {
            $pb->setTimeout($this->timeout);
        }

        return $pb;
    }
}
