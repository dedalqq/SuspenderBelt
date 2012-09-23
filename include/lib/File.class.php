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
    public $download_num;
    
    private $show_type;
    private $multiple;
    private $can_edit;
    private $preview_size;

    public function __construct($id = 0, $multiple = true, $can_edit = true) {
        $this->show_type = 1;
        $this->multiple = (bool)$multiple;
        $this->can_edit = $can_edit;
        $this->UploadFile();
        parent::__construct($id);
    }
    
    public function getTableName() {
        return 'files';
    }
    
    private function UploadFile() {
        if (!isset($_GET['file_upload']) || !isset($_FILES['file'])) {
            return false;
        }
        
        $file_num = count($_FILES['file']['name']);
        for($i=0; $i<$file_num; $i++) {

            if (!move_uploaded_file(
                    $_FILES['file']['tmp_name'][$i],
                    $GLOBALS['config']['file_storage'].$_FILES['file']['name'][$i].'_'.Date::now())) {
                continue;
            }
            
            $this->name = $_FILES['file']['name'][$i];
            $this->size = $_FILES['file']['size'][$i];
            $this->type = $_FILES['file']['type'][$i];
            $this->date = Date::now();
            $this->user_id = Autorisation::getInstance()->getUser()->getId();
            
            if ($this->multiple) {
                $this->id = 0;
            }
            
            $id = $this->save();
            
            if ($i == 0 && $this->multiple && !$this->group_id) {
                $this->group_id = $id;
                $this->save();
            }
        }
        
        echo "<script>
                window.parent.updateFile(".$id.", '".$_POST['file_form']."');
            </script>";
            
        exit();
        
        /**
         * @todo В одиночном режиме, при перезаписи удалять старый фаил
         * @param type $download
         * @return type 
         */
    }
    
    public function getUrl($download = false) {
        return 'handler.php?download_file='.$this->getId()
            .($download ? '&get_file=1' : '')
            .($this->preview_size ? '&preview='.$this->preview_size : '');
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
    
    public function getPreview($get_group = false) {
        
        $return_string = '';
        
        if ($get_group && $this->group_id != 0) {
            $sql = MySql::getInstance();
            $sql->db_select_table($this->getTableName());
            $sql->db_select_where('`group_id`='.$this->group_id);
            $result = $sql->db_exec(true);
            
            foreach ($result as $i => $v) {
                $this->setData($v);
                $return_string.= $this->getPreviewSingl();
            }
        }
        else {
            $return_string.= $this->getPreviewSingl();
        }
        
        $tpl = Tpl::getInstance();
        if ($this->can_edit) {
            $tpl->block('file_form');
            //$tpl->value('action', raplace_uri_parametrs(array('file_upload' => 1)));
            $tpl->value('f_name', 'file_'.rand(100, 10000));
            $return_string.= $tpl->echo_tpl('file.html');
        }
        
        return $return_string;
    }
    
    private function getPreviewSingl() {
        $tpl = Tpl::getInstance();
        
        if (!empty($this->name)) {
            $this->setPreviewSize(120);
            $tpl->value('file_url', $this->getUrl());
            $tpl->value('file_name', $this->name);
            $tpl->value('file_id', $this->getId());
            $tpl->value('file_size', byt_format($this->size));
            $tpl->value('file_date', Date::format($this->date));
            
            $tpl->block('file_preview');

            return $tpl->echo_tpl('file.html');
        }
        return '';
    }
    
    public function setShowTtype($value) {
        $this->show_type = $value;
    }
    
    public function SetMultiple($value = true) {
        $this->multiple = (bool)$value;
    }
    
    public function setPreviewSize($value = 100) {
        $this->preview_size = $value;
    }
    
    public function __toString() {
        
        $tpl = Tpl::getInstance();
        
        if ($this->show_type == 1) {
            $tpl->block('form_div');
            $tpl->block('file_form');
        }
        elseif($this->show_type == 2) {
            if ($this->type == 'audio/mp3') {
                $tpl->block('file_preview_audio');
            }
            else {
                $tpl->block('file_preview');
            }
        }
        $user = new User($this->user_id);
        $tpl->value('user_name', $user->login);
        $tpl->value('file_url', $this->getUrl());
        $tpl->value('file_name', substr($this->name, 0, 10));
        $tpl->value('file_id', $this->getId());
        $tpl->value('file_size', byt_format($this->size));
        $tpl->value('file_date', Date::format($this->date));
        $tpl->value('multiple', ($this->multiple ? 'multiple': ''));
        $tpl->value('action', raplace_uri_parametrs(array('file_upload' => 1)));
        $tpl->value('f_name', 'file_'.rand(100, 10000));
        
        return $tpl->echo_tpl('file.html');
    }
}

?>
