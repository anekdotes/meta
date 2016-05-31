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
 * Allows dispatching of events, based on listeners/subscribers.
 *
 * In other words, you create a dispatcher for a class, add a specific event(string), and then add subcribers(with listen()) (with functions to be called) on the event. Then, you call fire on the event, which dispatches all functions defined by the subscribers.
 */
class Dispatcher
{
    /**
   * Array containg all the events and their subscribers.
   *
   * Example structure :
   *
   * 	-> boot :
   * 	 	-> 0 : Closure -> this : Object whatever
   * 	-> request.before :
   * 	 	-> 0 : Closure -> this : Object whatever
   * 	 	-> 1 : Closure -> this : Object whatever
   *
   * @var array
   */
  private $subscribers = [];

  /**
   * Add a subscriber to an event.
   *
   * @param  string    $event     The event to which the subscriber needs to be added to
   * @param  \Closure  $callback  The subscriber to add to the event
   */
  public function listen($event, $callback)
  {
      if (!isset($this->subscribers[$event])) {
          $this->subscribers[$event] = [];
      }
      $this->subscribers[$event][] = $callback;
  }

  /**
   * Fires all subscriber functions tied to en avent.
   *
   * @return mixed Returns the return value of the callback, or FALSE on error.
   */
  public function fire()
  {
      $args = func_get_args();
      $event = array_shift($args);
      if (!isset($this->subscribers[$event])) {
          return false;
      }
      $result = null;
      foreach ($this->subscribers[$event] as $subscriber) {
          $result = call_user_func_array($subscriber, $args);
      }

      return $result;
  }

  /**
   * Removes all subscribers from the specified event. If no event is specified, remove all subscribers from all events.
   *
   * @param  string $event Event to flush subscribers from
   */
  public function flush($event = null)
  {
      if ($event === null) {
          $this->subscribers = [];
          return;
      }
      $this->subscribers[$event] = [];
  }
}
