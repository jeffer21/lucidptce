<?php
/**
 * Created by PhpStorm.
 * User: DSong
 * Date: 2/20/2018
 * Time: 5:01 PM
 */

class content extends Titan {

    public $active = 1;

    public function __construct() {
    }

    // get tracks
    public function getTrack($p) {
        $obj = new DB();
        $sql = 'SELECT *
        FROM t_track t
        WHERE t.p_id = "'.$obj->clean($p).'" AND
            t.active = "'.$this->active.'"
        ORDER BY t.tSort ASC
        ';
        $obj->sql($sql);
        $obj->run(1);
        return $obj;
    }

    // get modules
    public function getModule($t, $m = null) {
        $obj = new DB();
        $sql = 'SELECT *
        FROM t_module m
        WHERE m.t_id = "'.$obj->clean($t).'" AND
            m.active = "'.$this->active.'"
            '.($m?' AND m_id = "'.$m.'"':'').'
        ORDER BY m.mSort ASC
        ';
        $obj->sql($sql);
        $obj->run(1);
        return $obj;
    }

    // get content
    // cType_id reference
    // 1, multiple choice - vertical
    // 2, multiple choice - horizontal
    // 3, open ended - test
    // 4, open ended - textarea
    // 5, checkbox
    // 6, dropdown
    // 7, block
    public function getContent($t, $m) {
        $obj = new DB();
        $sql = 'SELECT c.*, ct.name AS "typeName"
        FROM t_content c
        INNER JOIN t_content_type ct ON (c.cType_id = ct.cType_id)
        WHERE c.t_id = "'.$obj->clean($t).'" AND
            c.m_id = "'.$obj->clean($m).'" AND
            c.active = "'.$this->active.'"
        ORDER BY c.cSort ASC, c.cSubSort ASC
        ';
        $obj->sql($sql);
        $obj->run(1);
        return $obj;
    }

    public function getQuestionSet($t, $m) {
        $obj = new DB();
        $sql = 'SELECT *
        FROM t_content c
        INNER JOIN t_choice ch ON (c.c_id = ch.c_id)
        WHERE c.t_id = "'.$obj->clean($t).'" AND
            c.m_id = "'.$obj->clean($m).'" AND
            c.active = "'.$this->active.'" AND
            ch.active = "'.$this->active.'"
        ORDER BY c.cSort ASC, c.cSubSort ASC, ch.c_id ASC, ch.chSort ASC
        ';
        $obj->sql($sql);
        $obj->run(1);
        return $obj;
    }

    // get question and choice by c_id
    public function getQuestion($c = null) {
        $obj = new DB();
        $sql = 'SELECT *
        FROM t_content c
        INNER JOIN t_choice ch ON (c.c_id = ch.c_id)
        WHERE c.c_id = "'.$obj->clean($c).'" AND
            c.active = "'.$this->active.'" AND
            ch.active = "'.$this->active.'"
        ORDER BY c.cSort ASC, c.cSubSort ASC, ch.chSort ASC
        ';
        $obj->sql($sql);
        $obj->run(1);
        return $obj;
    }

    // get programs by URL
    public function getProgram($pID = null) {

        $obj = new DB();

        $sql = 'SELECT p.*, pt.ptURL AS get1, pt.name AS "Type"
        FROM t_program p
        INNER JOIN t_program_type pt ON (p.pType_id = pt.pType_id)
        WHERE p.active = "'.$this->active.'" ';

        if ($pID) {
            $sql .= ' AND p.p_id = "'.$pID.'"';
        } else {
            if ($this->get(2)) {
                $sql .= ' AND p.pURL = "'.$obj->clean($this->get(2)).'"';
                $sql .= ' AND pt.ptURL = "'.$obj->clean($this->get(1)).'"';
            } else {
                $sql .= ' AND pt.ptURL = "'.$obj->clean($this->get(1)).'"';
            }

        }

        if ($this->addOn) {
            $sql .= ' AND '.$this->addOn;
        }

        $obj->sql($sql);
        $obj->run(1);

        return $obj;

    }


}