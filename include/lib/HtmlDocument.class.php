<?php

/**
 * Description of HtmlDocument
 *
 * @author dedal.qq
 */
class HtmlDocument {
    
    private static $object = NULL;
    
    private $print_only_content;
    
    /**
     * @var PageHeader
     */
    public $PageHeader;
    
    /**
     * @var PageMenu
     */
    public $PageMenu;
    
    /**
     * @var PageFooter
     */
    public $PageFooter;
    
    /**
     * @var HtmlElement[]
     */
    private $main_content = array();
    
    private function __construct() {
        $this->ParseHttpRequst();
        
        $this->main_content[0] = '';
        $this->PageHeader = new PageHeader();
        $this->PageMenu = new PageMenu();
        $this->PageFooter = new PageFooter();
    }
    
    /**
     * @return HtmlDocument
     */
    static public function getInstance() {
        if (!(self::$object != NULL && self::$object instanceof self)) {
            self::$object = new self;
        }
        return self::$object;
    }
    
    private function ParseHttpRequst() {
        $this->print_only_content = isset($_REQUEST['print_only_content']) ? true : false;
    }

    public function printDocument() {
        
        $tpl = Tpl::getInstance();
        header('Content-Type: text/html;charset='.$GLOBALS['config']['encoding']);
         if ($this->print_only_content) {
             print $this->getContent();
         }
         else {
            $tpl->value('header', (string)$this->PageHeader);
            $tpl->value('menu', (string)$this->PageMenu);

            $tpl->value('content', $this->getContent());

            $tpl->value('footer', (string)$this->PageFooter);
            
            $tpl->value('encoding', $GLOBALS['config']['encoding']);
            /**
             * @todo указывать тайтл страницы из какотого другого места 
             * Наверное лучше всего из индекса или из инициализации, но
             * из индекса явно лучше =)
             * а вообще пусть лучше тайтл указывает, или же хотя бы просто
             * может перезаписывать контроллер
             * который щас работает
             */
            $tpl->value('page_title', 'omg-team');
            
            print $tpl->echo_tpl('index.html');
         }
    }
    
    private function getContent() {
        $content = '';
        if (isset($this->main_content['content'])) {
            foreach ($this->main_content['content'] as $i => $v) {
                /**
                * @todo тут надо как то привести в порядок
                 * -- в следующий раз пиши, что конкртено не нравится
                */
                if (is_array($v)) {
                    bug($v);
                }
                if ($v != null) {
                    $content.= (string)$v;
                }
            }
        }
        
        if ($this->print_only_content) {
            $elements = array();
            if (!empty($content)) {
                $elements['content'] = $content;
            }
            foreach($this->main_content as $i => $v) {
                if ($i == 'content') {
                    continue;
                }
                $elements[$i] = (string)$v;
            }
            $elements['system_info'] = (string)SystemInfo::getInstance();
            $content = json_encode($elements);
        }
        
        return $content;
    }
    
    public function addContent($element = '', $palce = 'content') {
        if ($palce == 'content') {
            $this->main_content[$palce][] = $element;
        }
        else {
            $this->main_content[$palce] = $element;
        }
        return true;
    }
    
    /**
     * @todo Реализовать метод
     * @param type $title 
     */
    public function addPageTitle($title) {
        
    }
    
    public function getRequestUrl() {
        return $_SERVER['REQUEST_URI'];
    }
    
    public function get($value) {
        if (isset($_GET[$value])) {
            return $_GET[$value];
        }
    }
}

?>
