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

use Anekdotes\Meta\Dispatcher;
use PHPUnit_Framework_TestCase;

class DispatcherTest extends PHPUnit_Framework_TestCase
{
    public function testDispatcherProcedure()
    {
        $test = 'test';
        $test2 = 'test';
        $closure = function () use (&$test) {
            $test .= 's';
        };
        $closure2 = function () use (&$test2) {
            $test2 .= 'v';
        };
        $dispatcher = new Dispatcher();
        $dispatcher->listen('fire', $closure);
        $dispatcher->listen('fire', $closure2);
        $dispatcher->fire('fire');
        $this->assertEquals($test, 'tests');
        $this->assertEquals($test2, 'testv');
        $dispatcher->listen('toast', $closure);
        $dispatcher->flush('fire');
        $dispatcher->fire('fire');
        $dispatcher->fire('toast');
        $this->assertEquals($test, 'testss');
        $this->assertEquals($test2, 'testv');
        $dispatcher->flush();
        $dispatcher->fire('toast');
        $this->assertEquals($test, 'testss');
        $this->assertEquals($test2, 'testv');
    }

    public function testEmptyFire()
    {
        $dispatcher = new Dispatcher();
        $this->assertFalse($dispatcher->fire('test'));
    }
}
