<?php
/**
 * Created by PhpStorm.
 * User: DSong
 * Date: 2/20/2018
 * Time: 5:01 PM
 */

class ajax extends Titan {

    public function __construct($arr) {

        $this->act = $arr['act'];
        unset($arr['act']);
        unset($arr['ajax']);

        // getting standard ajax parameters, p_id, t_id, m_id, many more...
        foreach ($arr AS $key => $val) {
            $this->ajaxArg[$key] = $val;
        }

        // ajax action
        $this->action();

    }

    // determine ajax action, $this->ajaxArg['act']
    public function action() {

        // switch to differentiate all actions
        switch ($this->act) {

            case 'getProgram' :

                $obj = new content();
                $objProgram = $obj->getProgram($this->ajaxArg['p_id']);

                if ($objProgram->totalRow()) {

                    $this->returnArr['ajaxStatus'] = 1;
                    $this->returnArr['returned'] = $objProgram->getArray();

                } else {
                    $this->returnArr['ajaxStatus'] = 0;
                }

                $this->returnArr['act'] = $this->act;

                break;

        }


    }

    // echo results for ajax return
    public function getResult() {

        echo json_encode($this->returnArr);

    }


}