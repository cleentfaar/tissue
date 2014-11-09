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

use CL\Tissue\Adapter\AdapterInterface;
use Symfony\Component\Process\ExecutableFinder;

abstract class AdapterTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->adapter = $this->createAdapter();
    }

    public function testScan()
    {
        $actualResult = $this->adapter->scan([self::getPathToCleanFile()]);

        $this->assertInstanceOf('\CL\Tissue\Model\ScanResult', $actualResult);
    }

    public function testScanFile()
    {
        $actualResult = $this->adapter->scan([self::getPathToCleanFile()]);

        $this->assertCount(1, $actualResult->getFiles());
    }

    public function testScanDir()
    {
        $actualResult = $this->adapter->scan([self::getPathToCleanDir()]);

        $this->assertCount(1, $actualResult->getFiles());
    }

    /**
     * Tests scanning of a clean file, without a virus
     *
     * @group integration
     */
    public function testScanCleanFile()
    {
        $actualResult = $this->adapter->scan([self::getPathToCleanFile()]);

        $this->assertCount(0, $actualResult->getDetections());
    }

    /**
     * Tests scanning of a file with a (faked) virus
     *
     * @group integration
     */
    public function testScanInfectedFile()
    {
        $actualResult = $this->adapter->scan([self::getPathToInfectedFile()]);

        $this->assertCount(1, $actualResult->getDetections());
    }

    /**
     * Tests scanning of a file with a (faked) virus
     *
     * @group integration
     */
    public function testScanCleanDir()
    {
        $actualResult = $this->adapter->scan([self::getPathToCleanDir()]);

        $this->assertCount(0, $actualResult->getDetections());
    }

    /**
     * Tests scanning of a dir with a (faked) virus in it
     *
     * @group integration
     */
    public function testScanInfectedDir()
    {
        $actualResult = $this->adapter->scan([self::getPathToInfectedDir()]);

        $this->assertCount(1, $actualResult->getDetections());
    }

    /**
     * @return string
     */
    public static function getPathToCleanFile()
    {
        return self::getPathToFixture('clean/clean.txt');
    }

    /**
     * @return string
     */
    public static function getPathToCleanDir()
    {
        return self::getPathToFixture('clean');
    }

    /**
     * @return string
     */
    public static function getPathToInfectedFile()
    {
        return self::getPathToFixture('infected/infected.txt');
    }

    /**
     * @return string
     */
    public static function getPathToInfectedDir()
    {
        return self::getPathToFixture('infected');
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public static function getPathToFixture($name)
    {
        return realpath(sprintf('%s/../Fixtures/%s', __DIR__, $name));
    }

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
     * @return AdapterInterface
     */
    abstract protected function createAdapter();
}
