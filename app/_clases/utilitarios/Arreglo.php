<?php
/**
 * Created by PhpStorm.
 * User: walther
 * Date: 21/08/2018
 * Time: 04:43 PM
 */

namespace App\_clases\utilitarios;


class Arreglo
{

    public static function array_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                array_push($new_array, $array[$k]);
            }
        }

        return $new_array;
    }
    /**
     * ordena un arreglo comparando el indice de el arreglo con un arreglo especificado
     *
     * @param  array  $array
     * @param  array  $array_compare
     * @param    $order
     * @return array
     */
    public static function array_sort_on_array($array, $array_compare, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();
        if (count($array) > 0) {

            foreach ($array as $k => $v) {
                if (is_array($array_compare)&&isset($array_compare[$k])) {
                    $sortable_array[$k] = $array_compare[$k];
                } else {
                    $sortable_array[$k] = $k;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k]=$array[$k];
            }
        }

        return $new_array;
    }
}