<?php
/**
 * Description of File
 *
 * @author dedal.qq
 */
class File extends Object {
    
    public function __construct($id = 0) {
        parent::__construct($id);
    }
    public function getTableName() {
        return 'files';
    }
    
    public function __toString() {
        bug($_FILES);
        $form = Tpl::getInstance();
        $file = Tpl::getInstance();
        $form->block('form');
        $file->block('file');
        $form->value('method', 'post');
        $form->value('action', $_SERVER['REQUEST_URI']);
        $file->value('name', 'file');
        $form->value('form_contents', $file->echo_tpl('html_elements.html'));
        return $form->echo_tpl('html_elements.html');
    }
}

?>
