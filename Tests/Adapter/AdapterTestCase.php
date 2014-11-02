<?php

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
    protected function getPathToCleanFile()
    {
        return $this->getPathToFixture('clean.txt');
    }

    /**
     * @return string
     */
    protected function getPathToCleanFileAlternative()
    {
        return $this->getPathToFixture('clean_alt.txt');
    }

    /**
     * @return string
     */
    protected function getPathToInfectedFile()
    {
        return $this->getPathToFixture('virus.txt');
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
     * @param string $name
     *
     * @return string
     */
    protected function getPathToFixture($name)
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
     * @return AdapterInterface
     */
    abstract protected function createAdapter();
}
