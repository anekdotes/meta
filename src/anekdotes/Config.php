<?php

/*
 * This file is part of the Meta package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sitebase\Meta;
use Anekdotes\Meta\Registry;

/**
 * Allows loading and reading of config files, set in the website.
 */
class Config extends Registry {

  /**
   * Loads a config file, transforms its array to a dotted array
   *
   * @param string  $path       full path to config file
   * @param bool    $prefix     whether or not to prefix every field with file name
   * @param string  $namespace  name:: to put before avery config
   */
  public function loadFile($path, $prefix = false, $namespace = null) {
    $configFileContents = require $path;
    $prefixName = '';
    if ($prefix) {
      $prefixName = last(explode(DS, $path));
      $prefixName = trim(head(explode('.', $prefixName)), '/\\').'.';
    }
    if ( ! is_null($namespace)) {
      $prefixName = $namespace.'::'.$prefixName;
    }
    if (is_array($configFileContents)) {
      static::load(array_dot($configFileContents, $prefixName));
    }
  }

  /**
   * Loads a config folder (all .php's in there)
   *
   * @param string  $path       full path to config file
   * @param bool    $prefix     whether or not to prefix every field with file name
   * @param string  $namespace  name:: to put before avery config
   */
  public function loadFolder($folderPath, $prefix = false, $namespace = null) {
    $configFiles = glob($folderPath.'*.php');
    foreach ($configFiles as $path) {
      static::loadFile($path, $prefix, $namespace);
    }
  }

}
