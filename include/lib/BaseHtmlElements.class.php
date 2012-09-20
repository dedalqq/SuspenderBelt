<?php
/**
 * Description of BaseHtmlElements
 *
 * @author dedal.qq
 */
class BaseHtmlElements {
    
    private static $object;
    
    /**
     * @var Tpl
     */
    private $tpl;
    
    private function __construct() {
        $this->tpl = Tpl::getInstance();
        $this->tpl->initElements('elements.html');
    }
    
    /**
     * @return BaseHtmlElements
     */
    static public function getInstance() {
        if (!(self::$object != NULL && self::$object instanceof self)) {
            self::$object = new self;
        }
        return self::$object;
    }
    
    
}

?>
