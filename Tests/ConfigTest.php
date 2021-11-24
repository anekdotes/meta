<?php

/*
 * This file is part of the Meta package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Anekdotes\Meta\Config;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
final class ConfigTest extends TestCase
{
    public function testLoadFile()
    {
        $config = new Config();
        $config->loadFile('Tests/dummy/config/app/dummy.php');

        $this->assertEquals($config->all(), ['dummy' => 'dummy.php', 'test' => 'test.php']);

        //Testing prefix
        $config = new Config();
        $config->loadFile('Tests/dummy/config/app/dummy.php', true);

        $this->assertEquals($config->all(), ['dummy.dummy' => 'dummy.php', 'dummy.test' => 'test.php']);

        //Testing Namespace
        $config = new Config();
        $config->loadFile('Tests/dummy/config/app/dummy.php', false, 'Toaster');

        $this->assertEquals($config->all(), ['Toaster::dummy' => 'dummy.php', 'Toaster::test' => 'test.php']);

        //Testing both
        $config = new Config();
        $config->loadFile('Tests/dummy/config/app/dummy.php', true, 'Toaster');

        $this->assertEquals($config->all(), ['Toaster::dummy.dummy' => 'dummy.php', 'Toaster::dummy.test' => 'test.php']);
    }

    public function testLoadFolder()
    {
        $config = new Config();
        $config->loadFolder('Tests/dummy/config/app/');
        
        $this->assertEquals($config->all(), ['dummy' => 'dummy.php', 'test' => 'test.php', 'toast' => 'app/toast', 'me.you' => 'test']);
    }
}
