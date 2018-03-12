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

        $frameBanner = '<div id ="banner" class="banner">
            <div class="banner-text">
                <h3>Live Medical Crossfire</h3>
                <h1>An American Journal of Managed Care Medical Crossfire:</h1>
                <h2>Advancements in the Treatment of Migranes</h2>
                <hr>
                <p>Monday, October 16, 2017 | 6:00 PM CT
                    <br>
                    Sheraton Dallas Hotel | Dallas, Texas</p>
            </div>
        </div>';
        $this->setVar('frameBanner', $frameBanner);

        $this->setVar('body', $body);
    }

    function pageMeta() {
        $seoMeta["title"] = 'PTCE Beta';
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