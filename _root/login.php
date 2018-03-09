<?php
class login extends LucidPage {

    function pageHeader(){
    }

    public function pageView(){

        if ($this->isAuth()){
            $this->redirect('/');
            die();
        }else {
            $this->setView('frame', 'page');
        }

    }

    function pageCode(){

        if($_POST['email'] && $_POST['password']){

            $email = $_POST['email'];
            $password = $_POST['password'];

            $access = new access();
            $access->login($email,$password);
        }

        $login = '<form method="post" name="login" id="login">
            <div class="loginForm">
                <label class="floatLeft" for="email">Email Address</label>
                <input name="email" id="email" placeholder="Email Address" type="text">
                <label class="floatLeft" for="password">Password</label>
                <input name="password" id="password" placeholder="Password" type="password">
                <input type="submit" value="SUBMIT">
            </div>
            <input type="hidden" name="redirect" value="'.$_SERVER['HTTP_REFERER'].'">
        </form>';

        $this->setVar('content', $login);

    }

    function pageMeta(){

        $seoMeta["title"] = 'Login | PTCE';
        $seoMeta["keyword"] = '';
        $seoMeta["description"] = '';
        return $seoMeta;
    }

    public function pageAd(){
        return $arr;
    }

    function pageModule(){}
}
?>