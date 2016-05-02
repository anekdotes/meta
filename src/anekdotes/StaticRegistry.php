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
use Anekdotes\Meta\Registry;

/**
 * Allows a singleton Registry to be globally used with static methods.
 */
abstract class StaticRegistry {

  /**
   * Instance of Registry that will be used in this static context.
   * @var \Sitebase\Meta\Registry
   */
  private static $registry;

  /**
   * Check if StaticRegistry has a Registry
   *
   * @return bool if StaticRegistry has a Registry
   */
  private static function ensureRegistryPresence() {
    if (self::$registry === null) {
      self::$registry = new Registry();
    }
  }

  /**
   * Load a full array into StaticRegistry
   *
   * @param  array  $array  The array to load in the StaticRegistry
   * @return array          The instance of the Registry
   */
  public static function load($array) {
    self::ensureRegistryPresence();
    return self::$registry->load($array);
  }

  /**
   * Check if an item exists in the StaticRegistry
   *
   * @param  string  $item  Key of the item to check
   * @return bool           If the item exists
   */
  public static function has($item) {
    self::ensureRegistryPresence();
    return self::$registry->has($item);
  }

  /**
   * Set an item and its value in the StaticRegistry
   *
   * @param  string  $item   item key
   * @param  mixed   $value  item value
   * @return mixed          value entered
   */
  public static function set($item, $value) {
    self::ensureRegistryPresence();
    return self::$registry->set($item, $value);
  }

  /**
   * Get an item's value in the StaticRegistry. Allows a default value if the key provided does not exist
   *
   * @param  string  $item     item key
   * @param  string  $default  returned value if item does not exist
   * @return mixed             Value at the item's key
   */
  public static function get($item, $default = null) {
    self::ensureRegistryPresence();
    return self::$registry->get($item, $default);
  }

  /**
    * Returns a group of values using array_dot_get
    *
    * "toaster.toast.grasseh.whatever" would return all 4 values at these specific items, in an array.
    *
    * @param  string  $key  A string representing all the keys needed, seperated by a dot
    * @return array         An array of all the values asked by the key string
    *
    */
  public static function group($key) {
    return self::$registry->group($key);
  }

  /**
   * Get array of all items present in StaticRegistry
   *
   * @return array  all items in StaticRegistry
   */
  public static function all() {
    self::ensureRegistryPresence();
    return self::$registry->all();
  }

}
