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

use CL\Tissue\Adapter\AbstractAdapter;
use CL\Tissue\Model\ScanResult;

/**
 * MockAdapter for testing purposes
 *
 * NOTE: this adapter does a really lame job at detecting infections
 * It should only be used for simple functional tests.
 *
 * @package CL\Tissue\Tests\Adapter
 */
class MockAdapter extends AbstractAdapter
{
    /**
     * {@inheritdoc}
     */
    public function scan(array $paths, array $options = [])
    {
        $files      = [];
        $detections = [];

        $this->detectRecursive($paths, $files, $detections);

        return new ScanResult($paths, $files, $detections);
    }

    /**
     * @param array $paths
     * @param array $files
     * @param array $detections
     *
     * @return array
     */
    private function detectRecursive(array $paths, array &$files = [], array &$detections = [])
    {
        foreach ($paths as $path) {
            $path = realpath($path);
            if (!$path) {
                return;
            }

            if (is_dir($path)) {
                $this->detectRecursive($this->getFilesInDir($path), $files, $detections);

                return;
            }

            $files[] = $path;
            $content = file_get_contents($path);
            foreach (['infect', 'virus', 'eicar'] as $mockedInfection) {
                if (stristr($path, $mockedInfection) || stristr($content, $mockedInfection)) {
                    $detections[] = $path;

                    break;
                }
            }
        }
    }

    /**
     * @param string $dir
     *
     * @return array
     */
    private function getFilesInDir($dir)
    {
        $fileinfos = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
        $files     = [];
        foreach ($fileinfos as $pathname => $fileinfo) {
            if (!$fileinfo->isFile()) {
                continue;
            }

            $files[] = $pathname;
        }

        return $files;
    }
}
