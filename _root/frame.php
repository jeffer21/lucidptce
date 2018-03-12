<?php

class frame extends LucidFrame{

    public function frameHeader(){
    }

    public function frameCode(){

        $objTitan = new titan();

//        $access->login('gcardona@mjhassoc.com','Newyork79');
//        $access->logout();

        $this->setVar('frameBanner', '');

    }

    public function pageMeta(){
    }

    public function frameModule(){
    }

}
?>