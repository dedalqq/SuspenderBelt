<?php
/**
 * Description of UserSettings
 *
 * @author dedal.qq
 */
class UserSettings extends Object {
    
    protected $user_id;
    protected $name;
    protected $value;
    
    public function __construct() {
        parent::__construct();
        $this->user_id = Autorisation::getInstance()->getUser()->getId();
    }
    
    public function getTableName() {
        return 'user_settings';
    }
    
    public function getValue($name) {
        $this->name = $name;
        $this->load("`user_id`=".$this->user_id." AND `name`='".$this->name."'");
        return $this->value;
    }
    
    public function setValue($name, $value) {
        $this->name = $name;
        $this->load("`user_id`=".$this->user_id." AND `name`='".$this->name."'");
        $this->value = $value;
        $this->save();
    }
    
}

?>
