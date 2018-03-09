<?php

class home extends LucidPage{

    function pageHeader() {
        $header .= '';
        return $header;
    }

    public function pageView() {
        $this->setView('frame', 'home');
    }

    function pageCode() {
        $body = 'TESTING';

        $this->setVar('body', $body);
    }

    function pageMeta() {
        $seoMeta["title"] = '';
        $seoMeta["keyword"] = '';
        $seoMeta["description"] = '';
        return $seoMeta;
    }

    function pageModule() {
    }

    public function pageAd(){
        /*
        $arr['url'] = 'HOME';
        $arr['unit'][] = 'AD728x90L';
        $arr['unit'][] = 'AD728x90B';
        $arr['unit'][] = 'AD300x100';
        $arr['unit'][] = 'AD320x50L';
        $arr['unit'][] = 'AD300x250';
        $arr['unit'][] = 'AD300x250A';
        */
        return $arr;
    }

}

?>