<?php

namespace Pecee\Collection;

/**
 * Dot notation for access multidimensional arrays.
 *
 * $dn = new DotNotation(['bar'=>['baz'=>['foo'=>true]]]);
 *
 * $value = $dn->get('bar.baz.foo'); // $value == true
 *
 * $dn->set('bar.baz.foo', false); // ['foo'=>false]
 *
 * $dn->add('bar.baz', ['boo'=>true]); // ['foo'=>false,'boo'=>true]
 *
 * @author Anton Medvedev <anton (at) elfet (dot) ru>
 * @author Simon Sessingø
 * @version 2.0
 * @license MIT
 */

class DotNotation
{
    const SEPARATOR = '/[:\.]/';

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var array
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * @param string $path
     * @param string $default
     * @return mixed
     */
    public function get($path, $default = null)
    {
        $array = $this->values;

        if (empty($path) === false) {
            $keys = $this->explode($path);
            foreach ($keys as $key) {
                if (isset($array[$key])) {
                    $array = $array[$key];
                    continue;
                }

                return $default;
            }
        }

        return $array;
    }

    /**
     * @param string $path
     * @param mixed $value
     * @throws \RuntimeException
     */
    public function set($path, $value)
    {
        if (empty($path) === false) {
            $at = &$this->values;
            $keys = $this->explode($path);

            while (count($keys) > 0) {
                if (count($keys) === 1) {
                    if (is_array($at) === true) {
                        $at[array_shift($keys)] = $value;
                    } else {
                        throw new \RuntimeException("Can not set value at this path ($path) because is not array.");
                    }
                    continue;
                }
                $key = array_shift($keys);

                if (isset($at[$key]) === false) {
                    $at[$key] = [];
                }

                $at = &$at[$key];
            }
        } else {
            $this->values = $value;
        }
    }

    /**
     * @param $path
     * @param array $values
     * @throws \RuntimeException
     */
    public function add($path, array $values)
    {
        $get = (array)$this->get($path);
        $this->set($path, $this->arrayMergeRecursiveDistinct($get, $values));
    }

    /**
     * @param string $path
     * @return bool
     */
    public function have($path)
    {
        $keys = $this->explode($path);
        $array = $this->values;
        foreach ($keys as $key) {
            if (isset($array[$key]) === true) {
                $array = $array[$key];
                continue;
            }

            return false;
        }

        return true;
    }

    /**
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    protected function explode($path)
    {
        return preg_split(self::SEPARATOR, $path);
    }

    /**
     * array_merge_recursive does indeed merge arrays, but it converts values with duplicate
     * keys to arrays rather than overwriting the value in the first array with the duplicate
     * value in the second array, as array_merge does. I.e., with array_merge_recursive,
     * this happens (documented behavior):
     *
     * array_merge_recursive(array('key' => 'org value'), array('key' => 'new value'));
     *     => array('key' => array('org value', 'new value'));
     *
     * arrayMergeRecursiveDistinct does not change the datatypes of the values in the arrays.
     * Matching keys' values in the second array overwrite those in the first array, as is the
     * case with array_merge, i.e.:
     *
     * arrayMergeRecursiveDistinct(array('key' => 'org value'), array('key' => 'new value'));
     *     => array('key' => array('new value'));
     *
     * Parameters are passed by reference, though only for performance reasons. They're not
     * altered by this function.
     *
     * If key is integer, it will be merged like array_merge do:
     * arrayMergeRecursiveDistinct(array(0 => 'org value'), array(0 => 'new value'));
     *     => array(0 => 'org value', 1 => 'new value');
     *
     * @param array $array1
     * @param array $array2
     * @return array
     * @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
     * @author Gabriel Sobrinho <gabriel (dot) sobrinho (at) gmail (dot) com>
     * @author Anton Medvedev <anton (at) elfet (dot) ru>
     */
    protected function arrayMergeRecursiveDistinct(array &$array1, array &$array2)
    {
        $merged = $array1;

        foreach ($array2 as $key => &$value) {
            if (is_array($value) === true && isset($merged[$key]) === true && is_array($merged[$key]) === true) {
                if (is_int($key) === true) {
                    $merged[] = $this->arrayMergeRecursiveDistinct($merged[$key], $value);
                    continue;
                }
                $merged[$key] = $this->arrayMergeRecursiveDistinct($merged[$key], $value);
                continue;
            }

            if (is_int($key) === true) {
                $merged[] = $value;
                continue;
            }

            $merged[$key] = $value;
        }

        return $merged;
    }
}