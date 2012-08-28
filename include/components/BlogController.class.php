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
        $button = new HtmlElement();
        $button->getButton('������� ������', array('blog' => 'new_mass'));
        HtmlDocument::getInstance()->addContent($button);
        HtmlDocument::getInstance()->addContent($list);
        HtmlDocument::getInstance()->addContent($button);
    }
    
    private function newMass() {
        $blog_mass = new BlogMass();
        if (isset($_POST['save'])) {
            $blog_mass->parsHttpData();
            $page_info = new PageInfo();
            HtmlDocument::getInstance()->addContent($page_info);
            if ($blog_mass->subject == '' || $blog_mass->text == '') {
                $page_info->page_title = '����� ��������� ����������';
                $page_info->info_mass = '�� �� ����� ��������� ��� ��������� ���������';
                $page_info->setMassType('error');
            }
            else {
                $blog_mass->save();
                $page_info->page_title = '��������� ���������';
                $page_info->info_mass = '�����������, ���� ��������� ������� ���������';
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
