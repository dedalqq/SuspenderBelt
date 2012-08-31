<?php
/**
 * Description of BlogController
 *
 * @author dedal.qq
 */
class BlogController {
    
    private $mod;
    static private $object;
    
    private function __construct() {
        $this->mod = 'show_blog';
        if (isset($_GET['blog']) && !empty($_GET['blog'])) {
            $this->mod = $_GET['blog'];
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
        if ($this->mod == 'show_blog') {
            $this->printList();
        }
        elseif($this->mod == 'new_mass') {
            $this->newMass();
        }
        elseif ($this->mod == 'show_mass') {
            $this->showMass();
        }
    }
    
    private function printList() {
        $list = new BlogList();
        if (Autorisation::getInstance()->isLogin()) {
            $button = new HtmlElement();
            $button->getButton('Создать запись', './?blog=new_mass');
        }
        else {
            $button = '';
        }
        HtmlDocument::getInstance()->addContent($button);
        HtmlDocument::getInstance()->addContent($list);
        if (!$list->isEmpty()) {
            HtmlDocument::getInstance()->addContent($button);
        }
    }
    
    private function newMass() {
        if (!Autorisation::getInstance()->isLogin()) {
            $page_info = new PageInfo(
                    'Ошибка авторизации',
                    'Прежде чем писать сообщение, вам необходимо войти в систему.'
                );
            $page_info->setMassType('error');
            HtmlDocument::getInstance()->addContent($page_info);
            return false;
        }
        $blog_mass = new BlogMass();
        if (isset($_POST['save'])) {
            $blog_mass->parsHttpData();
            $page_info = new PageInfo();
            HtmlDocument::getInstance()->addContent($page_info);
            if ($blog_mass->subject == '' || $blog_mass->text == '') {
                $page_info->page_title = 'Форма заполнена некоректно';
                $page_info->info_mass = 'Вы не ввели сообщение или заголовок сообщения';
                $page_info->setMassType('error');
            }
            else {
                $blog_mass->save();
                $page_info->page_title = 'Сообщение сохранено';
                $page_info->info_mass = 'Поздравляем, ваще сообщение успешно сохранено';
                return true;
            }
        }
        HtmlDocument::getInstance()->addContent($blog_mass);
    }
    
    private function showMass() {
        if (isset($_GET['id'])) {
            $blog = new BlogMass((int)$_GET['id']);
            HtmlDocument::getInstance()->addContent($blog);
        }
    }
    
}

?>
