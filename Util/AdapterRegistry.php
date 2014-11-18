<?php

/*
 * This file is part of the Tissue library.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CL\Tissue\Util;

use CL\Tissue\Adapter\AdapterInterface;

class AdapterRegistry
{
    /**
     * @var AdapterInterface[]
     */
    protected $adapters = [];

    /**
     * @param AdapterInterface $adapter The adapter to register
     * @param string           $alias   The alias used to reference this adapter later
     */
    public function register(AdapterInterface $adapter, $alias)
    {
        $this->adapters[$alias] = $adapter;
    }

    /**
     * @param string $alias The alias of the adapter to retrieve
     *
     * @throws \InvalidArgumentException If there is no adapter registered with the given alias
     *
     * @return AdapterInterface
     */
    public function get($alias)
    {
        if (!array_key_exists($alias, $this->adapters)) {
            throw new \InvalidArgumentException(sprintf('There is no adapter registered under that alias: "%s"', $alias));
        }

        return $this->adapters[$alias];
    }

    /**
     * @param string $alias The alias of the adapter to check
     *
     * @return bool True if there is an adapter registered under the given alias, false otherwise
     */
    public function has($alias)
    {
        return array_key_exists($alias, $this->adapters);
    }
}
