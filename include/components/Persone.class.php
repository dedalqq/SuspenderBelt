<?php
/**
 * Description of Persone
 *
 * @author dedal.qq
 */
class Persone extends HtmlElement {
    
    public function __construct() {
        parent::__construct();
    }
    
    
    
    public function __toString() {
        
        $this->tpl->block('user_profil');
        
        return (string)$this->tpl->echo_tpl('persone.html');
    }
}

?>
