<?php

/**
 * Description of PageMenu
 *
 * @author dedal.qq
 */
class PageMenu extends PageElement {
    
    public $menuTitle;
    private $show;
    
    public function __construct() {
        parent::__construct();
        $this->show = false;
        $this->menuTitle = 'Меню';
    }
    
    public function menuOn() {
        $this->show = true;
    }
    
    public function menuOff() {
        $this->show = false;
    }

    public function __toString() {
        $this->tpl->value('menu_title', $this->menuTitle);
        $this->tpl->block('menu');
        
        if ($this->show) {
            return $this->tpl->echo_tpl('left_menu.html');
        }
        else {
            return '';
        }
    }
}

?>
