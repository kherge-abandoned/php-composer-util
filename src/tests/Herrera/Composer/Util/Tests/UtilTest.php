<?php

namespace Herrera\Composer\Util\Tests;

use Herrera\Composer\Util\Util;
use Herrera\PHPUnit\TestCase;

class UtilTest extends TestCase
{
    private $cwd;
    private $dir;

    public function testGetComposerLoader()
    {
        mkdir($this->dir . '/vendor');

        file_put_contents($this->dir . '/composer.json', '{}');
        file_put_contents(
            $this->dir . '/vendor/autoload.php',
            '<?php return "test";'
        );

        $this->assertEquals(
            'test',
            Util::getClassLoader($this->dir . '/composer.json')
        );
    }

    public function testGetComposerLoaderCustomVendor()
    {
        mkdir($this->dir . '/src/vendors', 0755, true);

        file_put_contents(
            $this->dir . '/composer.json',
            '{"config":{"vendor-dir": "src/vendors"}}'
        );
        file_put_contents(
            $this->dir . '/src/vendors/autoload.php',
            '<?php return "test";'
        );

        $this->assertEquals(
            'test',
            Util::getClassLoader($this->dir . '/composer.json')
        );
    }

    public function testGetComposerLoaderNotGenerated()
    {
        file_put_contents($this->dir . '/composer.json', '{}');

        $this->setExpectedException(
            'Herrera\\Composer\\Util\\Exception\\RuntimeException',
            'The Composer class loader "'
                . $this->dir
                . DIRECTORY_SEPARATOR
                . 'vendor'
                . DIRECTORY_SEPARATOR
                . 'autoload.php" could not be found.'
        );

        Util::getClassLoader($this->dir . '/composer.json');
    }

    public function testGetComposerPath()
    {
        $this->assertEquals(
            realpath(__DIR__ . '/../../../../../../composer.json'),
            Util::getComposerPath(__DIR__)
        );
    }

    public function testGetComposerPathSkip()
    {
        touch($this->dir . '/composer.json');
        mkdir($this->dir . '/some/other/sub/directory', 0755, true);
        touch($this->dir . '/some/other/sub/directory/composer.json');

        $this->assertEquals(
            $this->dir . DIRECTORY_SEPARATOR . 'composer.json',
            Util::getComposerPath(
                $this->dir . '/some/other/sub/directory',
                1
            )
        );
    }

    public function testGetComposerPathNotFound()
    {
        $this->setExpectedException(
            'Herrera\\Composer\\Util\\Exception\\RuntimeException',
            'The composer.json file could not be found.'
        );

        Util::getComposerPath($this->dir, 255);
    }

    protected function tearDown()
    {
        chdir($this->cwd);

        parent::tearDown();
    }

    protected function setUp()
    {
        $this->cwd = getcwd();
        $this->dir = $this->createDir();

        chdir($this->dir);
    }
}