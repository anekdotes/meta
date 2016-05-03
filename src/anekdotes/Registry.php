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
 * Base class used to store ANYTHING
 */
class Registry {

  /**
   * Array of all the objects of the registry
   * @var array
   */
  private $items = array();

  /**
   * Fills the registry with the array items (incremental)
   *
   * @param   array     $array  Items to add to the registry
   * @return  Registry          the instance of the registry
   */
  public function load($array) {
    $this->items = array_merge($this->items, $array);
    return $this;
  }

  /**
   * Check if the Registry is not empty
   *
   * @return bool  if the registry is not empty
   */
  public function hasItems() {
    return count($this->items) > 0 ? true : false;
  }

  /**
   * Check if an item exists in the registry
   *
   * @param  string  $item  Key of the item to check
   * @return bool           If the item exists
   */
  public function has($item) {
    return array_key_exists($item, $this->items);
  }

  /**
   * Set an item and its value in the registry
   *
   * @param  string  $item   item key
   * @param  mixed   $value  item value
   * @return mixed          value entered
   */
  public function set($item, $value) {
    return $this->items[$item] = $value;
  }

  /**
   * Get an item's value in the registry. Allows a default value if the key provided does not exist
   *
   * @param  string  $item     item key
   * @param  string  $default  returned value if item does not exist
   * @return mixed             Value at the item's key
   */
  public function get($item, $default = null) {
    return $this->has($item) ? $this->items[$item] : $default;
  }

  /**
   * removes an item from the registry
   *
   * @param  string  $item  item key
   */
  public function remove($item) {
    if ($this->has($item)) {
      unset($this->items[$item]);
    }
  }

  /**
    * Returns a value or more in the items, using the dot notation to decide where to fetch from.
    *
    * Ex:
    * $this->items = ["toaster.Sam" => "CoD","toaster.test" => "Toast","Mathieu" => "Patate"];
    * $this->group('toaster'); will then give ["Sam" => "CoD","test" => "Toast]
    *
    * @param  string  $key  A string representing all the keys needed, seperated by a dot
    * @return array         An array of all the values asked by the key string
    *
    */
  public function group($key) {
    return array_dot_get($this->all(), $key);
  }

  /**
   * Get array of all items present in registry
   *
   * @return array  all items in registry
   */
  public function all() {
    return $this->items;
  }

  /**
   * Empty the registry
   */
  public function flush() {
    $this->items = array();
  }

  /**
   * Replace this registry's values by another array of values
   * @param  array  $items  New values that will be used by this registry
   */
  public function replace(array $items) {
    $this->items = $items;
  }

  /**
   * Provide a string version of the Registry
   * @return string Stringified version of this registry
   */
  public function __toString() {
    $return = '';
    foreach ($this->items as $key => $value) {
      $return .= $key.": ".$value."\r\n";
    }
    return $return;
  }

}
