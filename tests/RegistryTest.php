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
    public function testLoad()
    {
        $registry = new Registry();
        $registry->load(["toaster" => "Toast","Mathieu" => "Patate"]);
        $registry->load(["Sam" => "Cod"]);
        $this->assertEquals($registry->all(),["toaster" => "Toast","Mathieu" => "Patate","Sam" => "Cod"]);
    }
}
