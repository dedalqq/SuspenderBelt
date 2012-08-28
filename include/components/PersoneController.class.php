<?php
/**
 * Description of PersoneController
 *
 * @author dedal.qq
 */
class PersoneController {
    
    private $object;
    
    /**
     * @var User
     */
    private $user;
    
    private function __construct() {
        if (isset($_GET['user'])) {
            $this->user = new User();
            //$this->user->load("`login`='".MySql::strHendler($_GET['user'])."'");
        }
        $this->controller();
    }
    
    static public function getInstance() {
        if (!(self::$object != NULL && self::$object instanceof self)) {
            self::$object = new self;
        }
        return self::$object;
    }
    
    private function controller() {
        
    }
}

?>
