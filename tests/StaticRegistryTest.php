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
use PHPUnit_Framework_TestCase; use Anekdotes\Meta\StaticRegistry;

class StaticRegistryTest extends PHPUnit_Framework_TestCase
{
    public function testLoadAndAll()
    {
        StaticRegistry::load(["toaster" => "Toast","Mathieu" => "Patate"]);
        StaticRegistry::load(["Sam" => "Cod"]);
        $this->assertEquals(StaticRegistry::all(),["toaster" => "Toast","Mathieu" => "Patate","Sam" => "Cod"]);
    }
    public function testHasTrue()
    {
        StaticRegistry::load(["Test" => "Toast"]);
        $this->assertTrue(StaticRegistry::has("Test"));
    }

    public function testHasFalse()
    {
        StaticRegistry::load(["Test" => "Toast"]);
        $this->assertFalse(StaticRegistry::has("Toast"));
    }

    public function testSetGet()
    {
        StaticRegistry::set("Toaster","Toast");
        $this->assertEquals(StaticRegistry::get("Toaster"),"Toast");
    }

    public function testGetDefault(){
        $this->assertEquals(StaticRegistry::get("Toaster","Toast"),"Toast");
    }

    public function testGroup(){
        StaticRegistry::load(["toaster" => "Toast","Mathieu" => "Patate","Sam" => "Cod"]);
        //$this->assertEquals(StaticRegistry::group("toaster.Sam"),["toaster" => "Toast","Sam" => "Cod"]);
    }
}
