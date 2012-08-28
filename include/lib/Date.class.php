<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Date
 *
 * @author dedal.qq
 */
class Date {
    
    static private $now;
    static private $months;
    
    private function __construct() {
        
    }
    
    static public function init() {
        self::$now = date('U');
        self::$months = array(
            1 => '���',
            2 => '���',
            3 => '���',
            4 => '���',
            5 => '���',
            6 => '���',
            7 => '���',
            8 => '���',
            9 => '���',
            10 => '���',
            11 => '���',
            12 => '���'
        );
    }
    
    static public function now() {
        return self::$now;
    }
    
    static public function format($date) {
        return date('j ', $date)
                .self::$months[date('n', $date)]
                .date(' Y H:i', $date);
    }
}

?>
