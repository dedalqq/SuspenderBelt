<?php
/**
 * Description of FileList
 *
 * @author dedal.qq
 */
class FileList extends ObjectList {
    
    public function __construct() {
        $this->object = new File;
        $this->object->setShowTtype(2);
        parent::__construct();
    }
}

?>
