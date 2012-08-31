<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HtmlElement
 *
 * @author dedal.qq
 */
class HtmlElement {
    
    /**
     * @var Tpl
     */
    protected $tpl;
    
    /**
     * @var string
     */
    protected $html = '';
    
    public function __construct() {
        $this->tpl = Tpl::getInstance();
    }

    public function __toString() {
        /**
         * @todo вот тут все как то очень печально 
         */
        return '<div class="html_elements">'.$this->html.'</div>';
    }
    
    public function getButton($name, $parametrs='') {
        if (is_array($parametrs)) {
            $url = raplace_uri_parametrs($parametrs);
        }
        else {
            $url = (string)$parametrs;
        }
        $this->tpl->block('button');
        $this->tpl->value('url', $url);
        $this->tpl->value('name', $name);
        return $this->tpl->echo_tpl('html_elements.html');
    }
}

?>
