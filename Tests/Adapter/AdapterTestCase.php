<?php

namespace CL\Tissue\Tests\Adapter;

use Symfony\Component\Process\ExecutableFinder;

abstract class AdapterTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string      $name
     * @param string|null $serverKey
     *
     * @return string
     */
    protected function findExecutable($name, $serverKey = null)
    {
        if ($serverKey && isset($_SERVER[$serverKey])) {
            return $_SERVER[$serverKey];
        }

        $finder = new ExecutableFinder();

        return $finder->find($name);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getPathToTestFile($name)
    {
        return sprintf(__DIR__ . '/../res/%s', $name);
    }

    /**
     * Tests the scanning of a single target (string)
     */
    abstract public function testScanSingle();

    /**
     * Tests the scanning of multiple targets (array)
     */
    abstract public function testScanMultiple();
}
