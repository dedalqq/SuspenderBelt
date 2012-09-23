<?php

/**
 * Description of User
 *
 * @author dedal.qq
 */
class User extends Object {
    
    public $login;
    public $password;
    public $date;
    public $avatar_id;
    public $first_name;
    public $last_name;
    public $mid_name;

    public function __construct($id = 0) {
        parent::__construct($id);
    }
    
    public function getTableName() {
        return 'users';
    }
    
    public function getLogin($link = true) {
        if ($link) {
            return '<a href="./?user='.$this->login.'" class="user_link">'.$this->login.'</a>';
        }
        else {
            return $this->login;
        }
    }
}

?>
