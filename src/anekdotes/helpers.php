<?php

/*
 * This file is part of the Meta package.
 *
 * (c) Anekdotes Communication inc. <info@anekdotes.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 if (!function_exists('array_dot')) {
     /**
     * Flatten a multi-dimensional associative array with dots. Taken and modified from Illuminate.
     *
     * @link   https://github.com/illuminate
     *
     * @param array  $array
     * @param string $prepend
     *
     * @return array
     */
    function array_dot($array, $prepend = '')
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $results = array_merge($results, array_dot($value, $prepend.$key.'.'));
            } else {
                $results[$prepend.$key] = $value;
            }
        }

        return $results;
    }
 }

 if (!function_exists('array_dot_get')) {
     /**
   * Get an item from an array using "dot" notation.
   *
   * @param   array   $array  array we're working on
   * @param   string  $key    key we want to get in the array, in the following format "key1.key2.key3"
   *
   * @return  mixed           obtained value
   */
  function array_dot_get($array, $key)
  {
      if (is_null($key)) {
          return $array;
      }

      if (isset($array[$key])) {
          return $array[$key];
      }
      $explodedKey = explode('.', $key);
      $sk = count($explodedKey);

      $return = [];
      foreach ($array as $node => $value) {
          if (\Anekdotes\Support\Str::startsWith($node, $key)) {
              $explodedNodeName = explode('.', $node);
              $sn = count($explodedNodeName);

              if ($sn > $sk + 1) {
                  $newNodeName = $explodedNodeName[$sk];
                  $return[$newNodeName] = array_dot_get($array, $key.'.'.$newNodeName);
              } else {
                  $return[$explodedNodeName[$sn - 1]] = $value;
              }
          }
      }

      return $return;
  }
 }
