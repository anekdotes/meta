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
use Anekdotes\Meta\Registry;
use PHPUnit_Framework_TestCase;

function test1(&$test)
{
    $test .= 's';
}
class tester
{
    public function test2(&$test)
    {
        $test .= 't';
    }
}

class ObjectArrayActionDispatcherTest extends PHPUnit_Framework_TestCase
{
    public function testObjectArrayDispatching()
    {
        $registry1 = new Registry();
        $registry1->load(['Test' => 'Tests', 'Toast' => 'Toasts']);
        $registry2 = new Registry();
        $registry2->load(['Test' => 'Nope', 'Toast' => 'Nope']);
        $dispatcher = new ObjectArrayActionDispatcher([$registry1, $registry2]);
        $dispatcher->set('Test', 'SuperTest');
        $this->assertEquals($registry1->get('Test'), 'SuperTest');
        $this->assertEquals($registry2->get('Test'), 'SuperTest');
    }

    public function testCallUserFuncArrayAndArrayDotGet()
    {
        $value = call_user_func_array('array_dot_get', [['toast' => 'toast'], null]);
        $this->assertEquals($value, ['toast' => 'toast']);
        $value = call_user_func_array('array_dot_get', [['toast' => 'toast'], 'toast']);
        $this->assertEquals($value, 'toast');
    }
}
