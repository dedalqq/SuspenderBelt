<?php
/**
 * Description of HtmlElement
 *
 * @author dedal.qq
 */
class PageElement {
    
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
        return $this->html;
    }
}

?>
