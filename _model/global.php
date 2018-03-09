<?php
/**
 * Created by PhpStorm.
 * User: DSong
 * Date: 11/16/2017
 * Time: 2:15 PM
 */

function docURL($obj, $row) {
    $arr[] = 'l_get1';
    $arr[] = 'l_get2';
    $arr[] = 'l_get3';
    $arr[] = 'l_get4';
    $arr[] = 'l_get5';
    $arr[] = 'l_get6';
    $output = '';
    for($x=0; $x<count($arr); $x++) {
        if($obj->display($arr[$x], $row)) {
            $output .= '/' . $obj->display($arr[$x], $row);
        }
    }
    return $output;
}

?>