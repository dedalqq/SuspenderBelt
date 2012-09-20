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
    
    private $show_type;

    public function __construct($id = 0) {
        $this->show_type = 1;
        parent::__construct($id);
    }
    public function getTableName() {
        return 'files';
    }
    
    public function getUrl($download = false, $preview = false) {
        return 'handler.php?download_file='.$this->getId()
            .($download ? '&get_file=1' : '')
            .($preview ? '&preview=1' : ''); //пока не работает и хз когда будет, мне в лом =)
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
    
    function setShowTtype($value) {
        $this->show_type = $value;
    }
    
    public function __toString() {
        
        $tpl = Tpl::getInstance();
        
        if ($this->show_type == 1) {
            $tpl->block('form_div');
            $tpl->block('file_form');
        }
        elseif($this->show_type == 2) {
            $tpl->block('file_preview');
        }
        
        $tpl->value('file_url', $this->getUrl());
        $tpl->value('file_name', $this->name);
        $tpl->value('file_id', $this->getId());
        $tpl->value('file_size', byt_format($this->size));
        $tpl->value('file_date', Date::format($this->date));
        
        $tpl->value('f_name', 'file_'.rand(100, 10000));
        
        return $tpl->echo_tpl('file.html');
    }
}

?>
