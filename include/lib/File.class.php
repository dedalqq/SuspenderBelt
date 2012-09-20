<?php
/**
 * Description of File
 *
 * @author dedal.qq
 */
class File extends Object {
    
    public $name;
    public $type;
    public $user_id;
    public $date;
    public $group_id;
    public $size;

    public function __construct($id = 0) {
        parent::__construct($id);
    }
    public function getTableName() {
        return 'files';
    }
    
    public function getUrl($download = false) {
        return 'handler.php?'.($download ? 'get_file=1&' : '').'download_file='.$this->getId();
    }
    
    public function getLink($print_size = false, $download = false) {
        $tpl = Tpl::getInstance();
        $name = $this->name;
        if ($print_size) {
            $name.= ' ('.byt_format($this->size).')';
        }
        $tpl->block('link');
        $tpl->value('url', $this->getUrl($download));
        $tpl->value('class', 'a_mode_on');
        $tpl->value('name', $name);
        
        return $tpl->echo_tpl('file.html');
    }
    
    public function __toString() {
        
        $tpl = Tpl::getInstance();
        
        $tpl->block('form');
        $tpl->value('f_name', 'file_'.rand(100, 10000));
        
        return $tpl->echo_tpl('file.html');
    }
}

?>
