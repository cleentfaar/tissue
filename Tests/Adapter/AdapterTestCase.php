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

    /**
     * @return string
     */
    public static function getPathToCleanFile()
    {
        return self::getPathToFixture(__FILE__);
    }

    /**
     * @return string
     */
    public static function getPathToCleanFileAlternative()
    {
        return self::getPathToFixture(__DIR__);
    }

    /**
     * @return string
     */
    public static function getPathToInfectedFile()
    {
        $path = self::getPathToFixture('virus.txt');
        if (!file_exists($path)) {
            // this let's us keep the repo clean (if even though it's a false-positive)
            $fh = fopen($path, 'w+');
            fwrite($fh, 'X5O!P%@AP[4\PZX54(P^)7CC)7}$EICAR-STANDARD-ANTIVIRUS-TEST-FILE!$H+H*');
            fclose($fh);
        }

        return $path;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public static function getPathToFixture($name)
    {
        return sprintf('%s/../Fixtures/%s', __DIR__, $name);
    }

    /**
     * Tests scanning of a clean file, without a virus
     *
     * @group integration
     */
    public function testScanWithoutVirus()
    {
        $actualResult = $this->adapter->scan($this->getPathToCleanFile());

        $this->assertCount(1, $actualResult->getFiles());
        $this->assertCount(0, $actualResult->getDetections());
    }

    /**
     * Tests scanning of a file with a (faked) virus
     *
     * @group integration
     */
    public function testScanWithVirus()
    {
        $actualResult = $this->adapter->scan($this->getPathToInfectedFile());

        $this->assertCount(1, $actualResult->getFiles());
        $this->assertCount(1, $actualResult->getDetections());
    }

    /**
     * Tests scanning of a file with a (faked) virus
     *
     * @group integration
     */
    public function testScanMultipleWithoutVirus()
    {
        $paths = [
            $this->getPathToCleanFile(),
            $this->getPathToCleanFileAlternative()
        ];

        $actualResult = $this->adapter->scan($paths);

        $this->assertCount(2, $actualResult->getFiles());
        $this->assertCount(0, $actualResult->getDetections());
    }

    /**
     * Tests scanning of a file with a (faked) virus
     *
     * @group integration
     */
    public function testScanMultipleWithVirus()
    {
        $paths = [
            $this->getPathToCleanFile(),
            $this->getPathToInfectedFile()
        ];

        $actualResult = $this->adapter->scan($paths);

        $this->assertCount(2, $actualResult->getFiles());
        $this->assertCount(1, $actualResult->getDetections());
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

    protected function tearDown()
    {
        parent::tearDown();

        // make sure we clean up any (faked) infections
        if (file_exists($this->getPathToInfectedFile())) {
            unlink($this->getPathToInfectedFile());
        }
    }

    /**
     * @return AdapterInterface
     */
    abstract protected function createAdapter();
}
