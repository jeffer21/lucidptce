<?php

class access extends Titan {

    private $dID;
    private $ucID;
    private $cValue;
    private $uriArray;

    public function __construct() {
        $this->setCookie();
        $this->uriArray = array_values(array_filter(explode("/",$_SERVER['REQUEST_URI'])));
    }

    // Set cookie to identify the user even if they are logged out. Do we logged them in?
    private function setCookie() {
        if(isset($_COOKIE['LUCIDSESSID'])) {
            $sqlD = 'SELECT dID FROM _lucid.masterSession WHERE sID LIKE "'.$_COOKIE['LUCIDSESSID'].'"';
            $objD = $this->runQuery($sqlD);
            $this->dID = $objD->display('dID');
        }

        //  1. Check for cookie
        //  a. If there is cookie check for dID and then update last access from that cookie
        if(isset($_COOKIE['PTCECID'])) {
            $this->cValue = $_COOKIE['PTCECID'];

            $sql = 'SELECT * FROM t_userCookie WHERE cValue = "'.$this->cValue.'"';
            $obj1 = $this->runQuery($sql);
            $this->ucID = $obj1->display('ucID');

            //  a1. If there is an user with this cookie update lastAccess
            if($obj1->display('dID') != 0) {
                $sql1 = 'UPDATE t_userCookie SET lastAccess = NOW() WHERE cValue = "'.$this->cValue.'" AND dID = "'.$obj1->display('dID').'"';

            //  a2. If user comes from another site and we have a dID find if there is a different cookie with this dID
            //      If there is another cookie associated with this user, delete the cookie w/out dID and update the content
            //      with the proper dID and cValue
            } else if ($this->dID) {
                $sql2 = 'SELECT * FROM t_userCookie WHERE dID = "'.$this->dID.'" LIMIT 0,1';
                $obj2 = $this->runQuery($sql2);

                if($obj2->display('t_userCookie') != $this->cValue && $obj2->totalRow() > 0) {

                    $sql3 = 'REPLACE INTO t_userLocation SET ucID = "'.$obj2->display('t_userCookie').'" WHERE ucID = "'.$this->ucID.'" AND get = "0"';
                    $this->runQuery($sql3);

                    $sql4 = 'DELETE FROM t_userCookie WHERE cValue = "'.$this->cValue.'"';
                    $this->runQuery($sql4);

                    $this->cValue = $obj2->display('t_userCookie');
                    $this->ucID = $obj2->display('ucID');

                    $sql1 = 'UPDATE t_userCookie SET lastAccess = NOW() WHERE cValue = "'.$this->cValue.'" AND dID = "'.$this->dID.'"';
                } else {
                    $sql1 = 'UPDATE t_userCookie SET dID = "'.$this->dID.'", lastAccess = NOW() WHERE  cValue = "'.$this->cValue.'"';
                }

            //  a3. If there is no dID, enter the cookie to start tracking of user even if dID is 0
            } else {
                $sql1 = 'UPDATE t_userCookie SET lastAccess = NOW() WHERE  cValue = "'.$this->cValue.'"';
            }

            $this->runQuery($sql1);

        //  b. If no cookie create one and insert with our without dID as needed
        } else {
            date_default_timezone_set("EST");
            $this->cValue = md5($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].date('Y-m-d H:i:s', time()).rand(0,1000000));

            //  b1. If user comes from another site and we have a dID find if there is a different cookie with this dID.
            //      If there is another cookie associated with this user, change cValue to the cookie w/ dID
            //      and update the content with the proper dID
            if ($this->dID) {
                $sql1 = 'INSERT INTO t_userCookie SET cValue = "'.$this->cValue.'", dID = "'.$this->dID.'"';
            } else {
                $sql1 = 'INSERT INTO t_userCookie SET cValue = "'.$this->cValue.'"';
            }

            $obj = $this->runQuery($sql1);
            $this->ucID = $obj->lastInsertID();
        }

        setcookie("PTCECID", $this->cValue, 2147483647, '/');

        $this->recordLocation();
    }

    private function recordLocation() {
        $url = $this->urlArray();

        $url = array_filter($url);

        if(sizeof($url) == 0) {
            $sqlD = 'SELECT * FROM t_userLocation WHERE ucID = "'.$this->ucID.'" AND getValue = "0"';
        } else {
            $get = sizeof($url);
            $sqlD = 'SELECT * FROM t_userLocation WHERE ucID = "'.$this->ucID.'" AND getValue = "'.$get.'" AND getURL = "'.$url[$get].'"';
        }

        $objD = $this->runQuery($sqlD);

        if(sizeof($url) == 0) {
            $locateURL = '/';
            if($objD->totalRow()) {
                $sqlI = 'UPDATE t_userLocation SET lastAccess = NOW() WHERE ucID = "'.$this->ucID.'" AND getValue = "0"';
            } else {
                $sqlI = 'INSERT INTO t_userLocation SET ucID = "'.$this->ucID.'", url = "'.$locateURL.'", getValue = "0", getURL = "home", lastAccess = NOW()';
            }
        } else {
            $locateURL = '/'.implode('/',$url);
            $get = sizeof($url);

            if($objD->totalRow()) {
                $sqlI = 'UPDATE t_userLocation SET lastAccess = NOW() WHERE ucID = "'.$this->ucID.'" AND getValue = "'.$get.'" AND getURL = "'.$url[$get].'"';
            } else {
                $sqlI = 'INSERT INTO t_userLocation SET ucID = "'.$this->ucID.'", url = "'.$locateURL.'", getValue = "'.$get.'", getURL = "'.$url[$get].'", lastAccess = NOW()';
            }
        }

        $ulID = $this->runQuery($sqlI);

        return $ulID;

    }

    public function loggedIn() {
        if($this->dID) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email = null, $password = null) {

        if($this->isAuth()) {
            header("Location: ".$_POST['redirect']);
            die();
        } else {
            if(!$email && !$password) {
                $this->alert('Please provide correct email address and password');
            } else {
                $email = strtolower($email);
                $var = $this->initAuth($email, $password);

                if (is_array($var) && $var['dID']) {
                    if($_POST['redirect'] == $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/login'){
                        header("Location: /");
                    } else{
                        $this->redirect(''.$_POST['redirect'].'');
                    }
                    die();
                } else {
                    $this->alert("Invalid email address or password.");
                    $this->redirect('/login');
                    die();
                }

            }
        }
    }

    public function logout() {
        $this->killAuth();
        $this->redirect('/');
        die();
    }

    public function trackAccess() {
        $url = $this->urlArray();

        if(sizeof($url) > 3 && !$this->dID) {

        }

    }

    public function testUArray() {

        // $accessArray[track_id][module_id] = true **Only equals true if user accessed it.
        $accessArray = array();
        $accessArray['track1']['module1'] = true;
        $accessArray['track1']['module2'] = true;
        $accessArray['track1']['module3'] = true;
        $accessArray['track1']['module4'] = true;

        $accessArray['track2']['module1'] = true;
        $accessArray['track2']['module2'] = true;
        $accessArray['track2']['module3'] = true;
        $accessArray['track2']['module4'] = true;
        $accessArray['track2']['module5'] = true;
        $accessArray['track2']['module6'] = true;
        $accessArray['track2']['module7'] = true;

        $accessArray['track3']['module1'] = true;
        $accessArray['track3']['module2'] = true;
        $accessArray['track3']['module3'] = true;
        $accessArray['track3']['module4'] = true;


        // $uArray[track_id][module_id] = true **Only equals true if user completed it.
        $completeArray = array();
        $completeArray['track1']['module1'] = true;
        $completeArray['track1']['module2'] = true;

        $completeArray['track2']['module1'] = true;
        $completeArray['track2']['module2'] = true;
        $completeArray['track2']['module3'] = true;
        $completeArray['track2']['module4'] = true;

        $completeArray['track3']['module1'] = true;


        // $uArray[track_id][module_id][question_id] = answer_id **Only equals true if user completed it.
        $submissionArray = array();
        $submissionArray['track1']['module1']['question1'] = 'answer_id';
        $submissionArray['track1']['module1']['question2'] = 'answer_id';
        $submissionArray['track1']['module1']['question3'] = 'answer_id';
        $submissionArray['track1']['module1']['question4'] = 'answer_id';
        $submissionArray['track1']['module2']['question1'] = 'answer_id';
        $submissionArray['track1']['module2']['question2'] = 'answer_id';
        $submissionArray['track1']['module2']['question3'] = 'answer_id';
        $submissionArray['track1']['module2']['question4'] = 'answer_id';

        $submissionArray['track2']['module1']['question1'] = 'answer_id';
        $submissionArray['track2']['module1']['question2'] = 'answer_id';
        $submissionArray['track2']['module1']['question3'] = 'answer_id';
        $submissionArray['track2']['module2']['question1'] = 'answer_id';
        $submissionArray['track2']['module2']['question2'] = 'answer_id';
        $submissionArray['track2']['module2']['question3'] = 'answer_id';
        $submissionArray['track2']['module2']['question4'] = 'answer_id';
        $submissionArray['track2']['module3']['question1'] = 'answer_id';
        $submissionArray['track2']['module3']['question2'] = 'answer_id';
        $submissionArray['track2']['module3']['question3'] = 'answer_id';
        $submissionArray['track2']['module4']['question1'] = 'answer_id';

        $submissionArray['track3']['module1']['question1'] = 'answer_id';
        $submissionArray['track3']['module1']['question2'] = 'answer_id';
        $submissionArray['track3']['module1']['question3'] = 'answer_id';
        $submissionArray['track3']['module1']['question4'] = 'answer_id';
        $submissionArray['track3']['module1']['question5'] = 'answer_id';
        $submissionArray['track3']['module1']['question6'] = 'answer_id';
        $submissionArray['track3']['module1']['question7'] = 'answer_id';

        print_r($submissionArray);die();
    }

}