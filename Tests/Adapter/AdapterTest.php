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

class AdapterTest extends AdapterTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createAdapter()
    {
        return new MockAdapter();
    }
}
