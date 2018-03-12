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

    // Keeps track of users access to different pages throughout the site
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

    // Check if user is logged in to track different access
    public function loggedIn() {
        if($this->dID) {
            return true;
        } else {
            return false;
        }
    }

    // Login for Lucid
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

    // Logout for lucid
    public function logout() {
        $this->killAuth();
        $this->redirect('/');
        die();
    }

    //  Sent array or json of completed and uncompleted tracks for specific program.
    //  Return type can either be 'array' or 'json'
    public function trackAccess($returnType = 'array') {
        $url = $this->urlArray();
        $p_id = $this->getPID($url);
        $pObj = $this->getPInfo($p_id);
        $accessArray = array();
        $returnArray = array();

        // Keep record starting $url[2] which has program URL in it
        if(sizeof($url) > 2 && $url[2] != '' && $this->ucID) {
            // 1. Check if use has accessed this program before
            $sql1 = 'SELECT * FROM t_userAccess WHERE ucID = "'.$this->ucID.'"';
            $obj1 = $this->runQuery($sql1);

            if($obj1->totalRow() < 1) {
                // First access to track. Find first track available and return it
                $track = $pObj->display('t_id',0);

                $accessArray[$p_id]['track'][$track] = true;
                $returnArray[$p_id][$track] = false;

                $sql = 'INSERT INTO t_userAccess (ucID, uAccessArray) VALUES ("'.$this->ucID.'","'.serialize($accessArray).'")';
                $this->runQuery($sql);
            } else {
                $userArray = $this->getUserArrays();
                $uCompleteArray = $userArray->display('uCompleteArray')[$p_id]['track'];

                //  2. Get size of program and confirm user completed all tracks
                $tObj = $this->getPInfo($p_id,'t_id');
                $pSize = $tObj->display('totalRow');

                //  2a. If so create an array with all the tracks completed
                if(sizeof($uCompleteArray) == $pSize) {
                    foreach ($uCompleteArray as $track_id) {
                        $returnArray[$p_id][$track_id] = true;
                    }
                } else {

                //  2b. Create an initial array with the completed tracks
                    foreach ($uCompleteArray as $track_id) {
                        $returnArray[$p_id][$track_id] = true;
                    }

                //  2c. Then add the remaining tracks that have not been completed
                    for($x=0; $x<$tObj->totalRow(); $x++) {
                        if(!in_array($tObj->display('t_id',$x),$returnArray[$p_id])) {
                            $returnArray[$p_id][$tObj->display('t_id',$x)] = false;
                        }
                    }
                }
            }

            if($returnType == 'json') {
                return json_encode($returnArray);
            } else {
                return $returnArray;
            }

        } elseif(!$this->ucID) {
            $this->alert('Check for cookie. There is no cookie');
            die();
        }
    }

    //  Sent array or json of completed and uncompleted tracks for specific program.
    //  Return type can either be 'array' or 'json'
    public function moduleAccess($returnType = 'array',$t_id) {
        $url = $this->urlArray();
        $p_id = $this->getPID($url);
        $tObj = $this->getPInfo($p_id, 'm_id', $t_id);
        $accessArray = array();

        // Keep record starting $url[2] which has program URL in it
        if(sizeof($url) > 2 && $url[2] != '' && $this->ucID) {
            // 1. Check if use has accessed this track before
            $userArray = $this->getUserArrays();
            $uAccessArray = $userArray->display('uAccessArray')[$p_id]['module'];


            if(!in_array($t_id,$uAccessArray)) {
                // First access to track. Create

                $accessArray = $uAccessArray;
                $accessArray[$p_id]['module'][$t_id] = true;
                $returnArray[$t_id][$tObj->display('m_id',0)] = false;

                $sql = 'UPDATE t_userAccess SET uAccessArray = "'.serialize($accessArray).'", updated = NOW() WHERE ucID = "'.$this->ucID.'"';
                $this->runQuery($sql);
            } else {
                $uCompleteArray = $userArray->display('uCompleteArray')[$p_id]['module'][$t_id];

                //  2. Get size of track and confirm user completed all modules
                $tSize = $tObj->display('totalRow');

                //  2a. If so create an array with all the tracks completed
                if(sizeof($uCompleteArray) == $tSize) {
                    foreach ($uCompleteArray as $module_id) {
                        $returnArray[$t_id][$module_id] = true;
                    }
                } else {

                    //  2b. Create an initial array with the completed tracks
                    foreach ($uCompleteArray as $module_id) {
                        $returnArray[$t_id][$module_id] = true;
                    }

                    //  2c. Then add the remaining tracks that have not been completed
                    for($x=0; $x<$tObj->totalRow(); $x++) {
                        if(!in_array($tObj->display('m_id',$x),$returnArray[$t_id])) {
                            $returnArray[$t_id][$tObj->display('m_id',$x)] = false;
                        }
                    }
                }
            }

            if($returnType == 'json') {
                return json_encode($accessArray);
            } else {
                return $accessArray;
            }

        } elseif(!$this->ucID) {
            $this->alert('Check for cookie. There is no cookie');
            die();
        }
    }

    //  Sent array or json of completed and uncompleted tracks for specific program.
    //  Return type can either be 'array' or 'json'
    public function contentAccess($returnType = 'array',$t_id) {
        $url = $this->urlArray();
        $p_id = $this->getPID($url);
        $tObj = $this->getPInfo($p_id, 'm_id', $t_id);
        $accessArray = array();

        // Keep record starting $url[2] which has program URL in it
        if(sizeof($url) > 2 && $url[2] != '' && $this->ucID) {
            // 1. Check if use has accessed this track before
            $userArray = $this->getUserArrays();
            $uAccessArray = $userArray->display('uAccessArray')[$p_id]['module'];


            if(!in_array($t_id,$uAccessArray)) {
                // First access to track. Create

                $accessArray = $uAccessArray;
                $accessArray[$p_id]['module'][$t_id] = true;
                $returnArray[$t_id][$tObj->display('m_id',0)] = false;

                $sql = 'UPDATE t_userAccess SET uAccessArray = "'.serialize($accessArray).'", updated = NOW() WHERE ucID = "'.$this->ucID.'"';
                $this->runQuery($sql);
            } else {
                $uCompleteArray = $userArray->display('uCompleteArray')[$p_id]['module'][$t_id];

                //  2. Get size of track and confirm user completed all modules
                $tSize = $tObj->display('totalRow');

                //  2a. If so create an array with all the tracks completed
                if(sizeof($uCompleteArray) == $tSize) {
                    foreach ($uCompleteArray as $module_id) {
                        $returnArray[$t_id][$module_id] = true;
                    }
                } else {

                    //  2b. Create an initial array with the completed tracks
                    foreach ($uCompleteArray as $module_id) {
                        $returnArray[$t_id][$module_id] = true;
                    }

                    //  2c. Then add the remaining tracks that have not been completed
                    for($x=0; $x<$tObj->totalRow(); $x++) {
                        if(!in_array($tObj->display('m_id',$x),$returnArray[$t_id])) {
                            $returnArray[$t_id][$tObj->display('m_id',$x)] = false;
                        }
                    }
                }
            }

            if($returnType == 'json') {
                return json_encode($accessArray);
            } else {
                return $accessArray;
            }

        } elseif(!$this->ucID) {
            $this->alert('Check for cookie. There is no cookie');
            die();
        }
    }

    // Check user access to track - mainly if they finish a track
    public function checkAccess() {

    }

    public function getPID($url) {
        $sql = 'SELECT p_id FROM t_program p INNER JOIN t_program_type t ON p.pType_id = t.pType_id WHERE p.pURL = "'.$url[2].'" AND t.ptURL = "'.$url[1].'"';
        $obj = $this->runQuery($sql,2);

        return $obj->display('p_id');
    }

    public function getUserArrays() {
        $sql = 'SELECT ua.uAccessArray, uc.uCompleteArray, us.uSubmissionArray, cookie.*
                FROM t_userCookie cookie
                INNER JOIN t_userAccess ua ON (cookie.ucID = ua.ucID)
                INNER JOIN t_userComplete uc ON (cookie.ucID = uc.ucID)
                INNER JOIN 	t_userSubmission us ON (cookie.ucID = us.ucID)
                INNER JOIN t_program_type t ON p.pType_id = t.pType_id
                WHERE cookie.ucID = "'.$this->ucID.'"';
        $obj = $this->runQuery($sql,1);

        return $obj;
    }
    
    public function getPInfo($p_id, $groupBy = null, $t_id = null) {

        if($groupBy == 't_id') {
            $sqlOption = ' GROUP BY t_id ';
        } else if($groupBy == 'm_id') {
            $sqlOption = ' AND tt.t_id = "'.$t_id.'" GROUP BY m_id ';
        } else {
            $sqlOption  = '';
        }

        $sql = 'SELECT *
                FROM t_program tp
                INNER JOIN t_track tt ON tp.p_id = tt.p_id
                INNER JOIN t_module tm ON tt.t_id = tm.t_id
                INNER JOIN t_content tc ON tm.m_id = tc.m_id
                WHERE tp.p_id = "'.$p_id.'"'.$sqlOption.'
                ORDER BY tt.tSort ASC, tm.mSort ASC, tc.cSort ASC, tc.cSubSort ASC';

        $obj = $this->runQuery($sql);
        return $obj;
    }

    public function testUArray() {

        // $accessArray[track_id][module_id] = true **Only equals true if user accessed it.
        $accessArray = array();
        $accessArray['program1']['track1']['module1'] = true;
        $accessArray['program1']['track1']['module2'] = true;
        $accessArray['program1']['track1']['module3'] = true;
        $accessArray['program1']['track1']['module4'] = true;

        $accessArray['program1']['track2']['module1'] = true;
        $accessArray['program1']['track2']['module2'] = true;
        $accessArray['program1']['track2']['module3'] = true;
        $accessArray['program1']['track2']['module4'] = true;
        $accessArray['program1']['track2']['module5'] = true;
        $accessArray['program1']['track2']['module6'] = true;
        $accessArray['program1']['track2']['module7'] = true;

        $accessArray['program1']['track3']['module1'] = true;
        $accessArray['program1']['track3']['module2'] = true;
        $accessArray['program1']['track3']['module3'] = true;
        $accessArray['program1']['track3']['module4'] = true;


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

        print_r($accessArray);die();
    }

}