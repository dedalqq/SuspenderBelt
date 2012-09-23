<?php
/**
 * Description of UserSettingsController
 *
 * @author dedal.qq
 */
class UserSettingsController {
    
    static private $object;
    
    private function __construct() {
        
        $this->controller();
    }
    
    static public function getInstance() {
        if (!(self::$object != NULL && self::$object instanceof self)) {
            self::$object = new self;
        }
        return self::$object;
    }
    
    private function controller() {
        if (!Autorisation::getInstance()->getUser()->getId()) {
            $page_info = new PageInfo(
                    'Ошибка авторизации',
                    'Прежде чем получить доступ к этому разделу, вам необходимо войти в систему.'
                );
            $page_info->setMassType('error');
            HtmlDocument::getInstance()->addContent($page_info);
            return false;
        }
        $user_settings = new UserSettings;
        
        HtmlDocument::getInstance()->addContent($user_settings);
    }
}

?>
