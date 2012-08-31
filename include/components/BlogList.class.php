<?php
/**
 * Description of BlogList
 *
 * @author dedal.qq
 */
class BlogList extends ObjectList {
    
    public function __construct() {
        $this->object = new BlogMass();
        parent::__construct();
    }
}

?>
