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

use Anekdotes\Meta\ObjectArrayActionDispatcher;
use PHPUnit_Framework_TestCase;

class DispatcherTest extends PHPUnit_Framework_TestCase
{
    public function testObjectArrayDispatching()
    {
        $test = 'test';
        $test2 = 'test';
        $closure = function () use (&$test) {
            $test .= 's';
        };
        $closure2 = function () use (&$test2) {
            $test2 .= 'v';
        };
        $dispatcher = new ObjectArrayActionDispatcher(["ActionOne" => ["fire" => $closure],"ActionTwo" => ["fire" => $closure2]]);
        $dispatcher->fire();
        $this->assertEquals($test, 'tests');
        $this->assertEquals($test2, 'testv');
    }
}
