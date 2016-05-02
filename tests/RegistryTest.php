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
use PHPUnit_Framework_TestCase; use Anekdotes\Meta\Registry;

class RegistryTest extends PHPUnit_Framework_TestCase
{
    public function testLoadAndAll()
    {
        $registry = new Registry();
        $registry->load(["toaster" => "Toast","Mathieu" => "Patate"]);
        $registry->load(["Sam" => "Cod"]);
        $this->assertEquals($registry->all(),["toaster" => "Toast","Mathieu" => "Patate","Sam" => "Cod"]);
    }

    public function testHasItemsTrue()
    {
        $registry = new Registry();
        $registry->load(["Test" => "Toast"]);
        $this->assertTrue($registry->hasItems());
    }

    public function testHasItemsFalse()
    {
        $registry = new Registry();
        $this->assertFalse($registry->hasItems());
    }

    public function testHasTrue()
    {
        $registry = new Registry();
        $registry->load(["Test" => "Toast"]);
        $this->assertTrue($registry->has("Test"));
    }

    public function testHasFalse()
    {
        $registry = new Registry();
        $registry->load(["Test" => "Toast"]);
        $this->assertFalse($registry->has("Toast"));
    }

    public function testSetGet()
    {
        $registry = new Registry();
        $registry->set("Toaster","Toast");
        $this->assertEquals($registry->get("Toaster"),"Toast");
    }

    public function testGetDefault(){
        $registry = new Registry();
        $this->assertEquals($registry->get("Toaster","Toast"),"Toast");
    }

    public function testRemove(){
        $registry = new Registry();
        $registry->load(["toaster" => "Toast","Mathieu" => "Patate"]);
        $registry->remove("toaster");
        $this->assertFalse($registry->has("toaster"));
        $this->assertTrue($registry->has("Mathieu"));
    }

    public function testFlush(){
        $registry = new Registry();
        $registry->load(["toaster" => "Toast","Mathieu" => "Patate"]);
        $registry->flush();
        $this->assertFalse($registry->has("toaster"));
        $this->assertFalse($registry->has("Mathieu"));
    }

    public function testGroup(){
        $registry = new Registry();
        $registry->load(["toaster" => "Toast","Mathieu" => "Patate","Sam" => "Cod"]);
        //$this->assertEquals($registry->group("toaster.Sam"),["toaster" => "Toast","Sam" => "Cod"]);
    }

    public function testReplace(){
        $registry = new Registry();
        $registry->load(["toaster" => "Toast","Mathieu" => "Patate"]);
        $registry->replace(["Sam" => "Cod"]);
        $this->assertEquals($registry->all(),["Sam" => "Cod"]);
    }

    public function testToString(){
        $registry = new Registry();
        $registry->load(["toaster" => "Toast","Mathieu" => "Patate"]);
        $this->assertEquals($registry->__toString(),"toaster: Toast\r\nMathieu: Patate\r\n");
    }
}
