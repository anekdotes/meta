<?php

/*
 * This file is part of the Meta package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anekdotes\Meta;

/**
 * A basic dispatcher, based on an object array.
 *
 * This dispatcher contains multiple objects in an array. Each object must contain a function of the desired name, which will be called on all objects on call.
 *
 * To use this dispatcher, you simply need to create it with an Object Array, containing your objects in the array. Then, you just need to call it with the desired parameters.
 */
class ObjectArrayActionDispatcher
{
    /**
     * Objects the calls will be dispatched to.
     *
     * @var array
     */
    private $objects;

    /**
     * Constructor function. Initializes the object listener array.
     *
     * @param array $objects Objects that have a function to execute on fire.
     */
    public function __construct($objects = [])
    {
        $this->objects = $objects;
    }

    /**
     * Fires a specific object in the dispatcher.
     *
     * @param string $name Name of the method to be called on all objects
     * @param array  $args Arguments to be passed in the function call
     *
     * @return ObjectArrayActionDispatcher The instance of this object
     */
    public function __call($name, $args)
    {
        foreach ($this->objects as $object) {
            call_user_func_array([$object, $name], $args);
        }

        return $this;
    }
}
