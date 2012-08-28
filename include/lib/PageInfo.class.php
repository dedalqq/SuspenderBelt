<?php

/**
 * Description of PageInfo
 *
 * @author dedal.qq
 */
class PageInfo extends HtmlElement {
    
    public $page_title;
    private $mass_type;
    public $info_mass;
    
    public function __construct() {
        $this->mass_type = 'ok';
        parent::__construct();
    }

    function __toString() {
        if (!empty($this->page_title)) {
            $this->tpl->value('page_title', $this->page_title);
            $this->tpl->block('page_title');
        }
        
        if (!empty($this->info_mass)) {
            $this->tpl->value('info_mass', $this->info_mass);
            $this->tpl->block('info_mass');
        }
        $this->tpl->value('mass_type', $this->mass_type);
        //bug(debug_backtrace(), true);
        return $this->tpl->echo_tpl('info_page.html');
    }
    
    /**
     * Устанавливает тип сообщения
     * @param string (ok|not_ok|warning|error) 
     */
    public function setMassType($type = 'ok') {
        $this->mass_type = $type;
    }
}

?>
