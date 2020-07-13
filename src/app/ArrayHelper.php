<?php
/**
 * ArrayHelper
 *
 * This file contains the array Helper implementation
 *
 * PHP version 7
 *
 * @category AppModule
 * @package  App
 * @author   David Caicedo <caicedodavid05@gmail.com>
 * @license  http://www.php.net/license/7_01.txt  PHP License 7.3
 * @link     http://pear.php.net/package/PackageName
 */

namespace App;

/**
 * Class ArrayHelper
 *
 * @category AppModule
 * @package  App
 * @author   David Caicedo <caicedodavid05@gmail.com>
 * @license  http://www.php.net/license/7_01.txt  PHP License 7.3
 * @link     http://pear.php.net/package/PackageName
 */
class ArrayHelper
{

    /**
     * Safe get an element form an array.
     *
     * @param array  $array   Array to be searched
     * @param string $key     key to be searched in array
     * @param mixed  $default default value to return if it does not exist
     *
     * @return void
     */
    static public function get(array $array, string $key, $default = null)
    {
        return array_key_exists($key, $array) ? $array[$key] : $default;
    }

    /**
     * Method for checking if it is a sequential array
     *
     * @param array $array Array to check
     *
     * @return bool
     */
    static function isSequentialArray($array) : bool
    {
        return array_key_exists(0, $array);
    }
}
