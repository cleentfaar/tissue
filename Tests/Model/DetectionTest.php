<?php

/*
 * This file is part of the Tissue library.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CL\Tissue\Tests\Model;

use CL\Tissue\Model\Detection;

class DetectionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPath()
    {
        $path      = 'foobar1.txt';
        $detection = new Detection($path);

        $this->assertEquals($path, $detection->getPath());
    }

    public function testGetType()
    {
        $type      = Detection::TYPE_VIRUS;
        $detection = new Detection('foobar1.txt', $type);

        $this->assertEquals($type, $detection->getType());
    }
}
