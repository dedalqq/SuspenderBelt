<?php

/**
 * Description of BlogMass
 *
 * @author dedal.qq
 */
class BlogMass extends Object {
    
    public $subject;
    public $text;
    public $user_id;
    public $date;
    
    /**
     * @var User
     */
    private $user;
    
    private $printMode;

    public function __construct($id = 0) {
        parent::__construct($id);
        
        $this->printMode = 1;
    }
    
    public function getTableName() {
        return 'blogs';
    }
    
    public function setModeEdit() {
        $this->printMode = 2;
    }
    
    public function setData($array) {
        parent::setData($array);
        $this->user = new User($this->user_id);
    }
    
    public function save() {
        if (!(bool)$this->user_id) {
            $this->user = Autorisation::getInstance()->getUser();
            $this->user_id = $this->user->getId();
        }
        if (!(bool)$this->date) {
            $this->date = Date::now();
        }
        parent::save();
    }

    public function __toString() {
        $tpl = Tpl::getInstance();
        
        $tpl->value('blogs_subject', $this->subject);
        $tpl->value('blogs_date', Date::format($this->date));
        $tpl->value('blogs_text', $this->text);
        $tpl->value('blogs_id', $this->getId());
        $tpl->value('blog_action', $_SERVER['REQUEST_URI']);
        if ($this->user instanceof User) {
            $tpl->value('blogs_login', $this->user->getLogin());
        }
        
        if (!(bool)$this->getId() || $this->printMode == 2) {
            $tpl->block('blog_form');
            
            if ((bool)$this->getId()) {
                $tpl->value('editor_mod', 'Редактировать запись');
            }
            else {
                $tpl->value('editor_mod', 'Создать новую запись');
            }
        }
        else {
            $tpl->block('blog');
        }
        
        return $tpl->echo_tpl('blog_mass.html');
    }
}

?>
