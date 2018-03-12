<?php

class on_demand extends LucidPage{

    function pageHeader() {
        $header .= '';
        return $header;
    }

    public function pageView() {
        $this->setView('frame', 'page');
    }

    function pageCode() {

        if ($this->get(2)) {

            $obj = new content();
            $objProgram = $obj->getProgram();
            $objTrack = $obj->getTrack($objProgram->display('p_id'));
            $objModule = $obj->getModule($objTrack->display('t_id'));





            // front matter pop-up
            if ($objProgram->display('content')) {
                $content .= '<script>activityPop('.$objProgram->display('p_id').');</script>';
            }



        } else {

            $obj = new content();
            $objProgram = $obj->getProgram();

            for ($x=0; $x< $objProgram->totalRow(); $x++) {
                $content .= '<div><a href="/'.$objProgram->display('get1',$x).'/'.$objProgram->display('pURL',$x).'">'.$objProgram->display('name',$x).'</a></div>';
            }

        }

        $this->setVar('content', $content);

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