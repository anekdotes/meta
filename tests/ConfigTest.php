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
use PHPUnit_Framework_TestCase; use Anekdotes\Meta\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testLoadFile()
    {
        $config = new Config();
        $config->loadFile('tests/dummy/config/app/dummy.php');
        $this->assertEquals($config->all(),["dummy" => "dummy.php","test" =>  "test.php"]);
    }

    public function testLoadFolder(){
        $config = new Config();
        $config->loadFolder('tests/dummy/config/app/');
        $this->assertEquals($config->all(),["dummy" => "dummy.php","test" =>  "test.php","toast" => "app/toast", "me.you" => "test"]);
    }
}
