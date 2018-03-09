<?php
/**
 * class TITAN
 * base class to load
 * will load all sub class
 *
 */

// require Base.php for lucid standard functions
/*
mailer, get, getData, docURL, Form, AutoQuery, alert, redirect, est, utc, now, microNow, systemData, humanDate, clearDocCache,
killSession, setSession, getSession, copyLucidSession, killLucidSession, lucidSession, setLucidSession, getLucidSession,
getMasterDataByMD5, getMasterData, getUserData, forgotAuth, resetAuth, requestActivation, activateAuth, updateAuth, createAuth,
isOnline, isAuth, switchDB, killAuth, switchAuth, initAuth, cleanSession, remoteAuth, optAuth, Excel, Text, csv
*/
require_once(ROOT.'_framework/1/Base.php');

class Titan extends Base {

    // initiate Titan class
    public function __construct() {

        // preload all titan sub classes
        $this->loadClass();

        // run ajax method
        if ($_POST['ajax'] == 'titan') {

            // set as an array for passed parameters
            foreach ($_POST AS $key => $val) {
                $argArr[$key] = $val;
            }

            // initiate ajax class
            $obj = new ajax($argArr);
            $obj->getResult();
            die();

        }

    }

    // load all sub classes
    protected function loadClass() {
        $this->classListArr = array(
            'titan.access.php',
            'titan.content.php',
            'titan.history.php',
            'titan.report.php',
            'titan.user.php',
            'titan.ajax.php'
        );
        foreach ($this->classListArr AS $val) {
            if (file_exists(__DIR__.'/'.$val)) {
                require_once($val);
            }
        }
    }

    // redirect, override from Base.class
    protected function redirect($url, $msg = null) {
        if ($msg) {
            echo '<script>alert("'.$msg.'");</script>';
        }
        echo '<script>window.location.href = "'.$url.'";</script>';
        die();
    }

    // run a query, default mode = 1
    protected function runQuery($query, $mode = 1) {
        $obj = new DB();
        $obj->sql($query);
        $obj->run($mode);
        return $obj;
    }

    protected function urlArray() {
        $obj = new DB();

        $url[1] = $obj->clean($this->get(1));
        $url[2] = $obj->clean($this->get(2));
        $url[3] = $obj->clean($this->get(3));
        $url[4] = $obj->clean($this->get(4));
        $url[5] = $obj->clean($this->get(5));
        $url[6] = $obj->clean($this->get(6));

        return $url;
    }


}