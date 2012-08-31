<?php
/**
 * Description of Persone
 *
 * @author dedal.qq
 */
class Persone extends HtmlElement {
    
    /**
     * @var User
     */
    private $user;
    
    public function __construct() {
        parent::__construct();
        if (isset($_GET['user'])) {
            $this->user = new User;
            $this->user->load("`login`='".MySql::strHendler($_GET['user'])."'");
        }
    }
    
    
    
    public function __toString() {
        
        $this->tpl->block('user_profil');
        $this->tpl->value('login', $this->user->login);
        return (string)$this->tpl->echo_tpl('persone.html');
    }
}

?>
