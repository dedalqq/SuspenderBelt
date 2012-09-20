<?php

/**
 * Description of PageHeader
 *
 * @author dedal.qq
 */
class PageHeader extends PageElement {
    
    private $menu_elements = array();
    private $menu_elements_right = array();
    
    public function __toString() {
        //bug($this->tpl);
        $this->tpl->value('form_login', (string)Autorisation::getInstance());
        
        if (count($this->menu_elements) > 0) {
            $this->tpl->block('menu_itm');
        }
        
        
        if (count($this->menu_elements_right) > 0) {
            $this->tpl->block('menu_itm_right');
        }
        
        foreach($this->menu_elements as $i => $v) {
            $this->tpl->value('menu_itm_mod', $i);
            $this->tpl->value('menu_itm_text', $v);
        }
        
        foreach($this->menu_elements_right as $i => $v) {
            $this->tpl->value('menu_itm_mod_right', $i);
            $this->tpl->value('menu_itm_text_right', $v);
        }
        
        return $this->tpl->echo_tpl('header.html');
    }
    
    public function addMenuElement($mod, $value) {
        $this->menu_elements[$mod] = $value;
    }
    
    public function addMenuElementRight($mod, $value) {
        $this->menu_elements_right[$mod] = $value;
    }
}

?>
