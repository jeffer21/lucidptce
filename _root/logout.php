<?php
class logout extends LucidPage {

    function pageHeader(){
    }

    public function pageView(){
        $this->setView('frame', 'page');
    }

    function pageCode(){

        $access = new access();
        $access->logout();
//        $this->killAuth();
//        $this->redirect('/');
//        die();

    }

    function pageMeta(){
        $seoMeta["title"] = 'Logout | PTCE';
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