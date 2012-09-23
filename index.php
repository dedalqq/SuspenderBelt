<?php

include 'config.php';
include 'include/init.php';

HtmlDocument::getInstance()->PageHeader->addMenuElement('blog', 'Блог');
HtmlDocument::getInstance()->PageHeader->addMenuElement('log', 'Логи');

if ((bool)Autorisation::getInstance()->getUser()->getId()) {
    HtmlDocument::getInstance()->PageHeader->addMenuElementRight('file', 'Файлы');
    HtmlDocument::getInstance()->PageHeader->addMenuElementRight('settings', 'Настройки');
}

HtmlDocument::getInstance()->PageMenu->menuOn();

if (isset($_GET['autorisation'])) {
    Autorisation::getInstance()->controller();
}
elseif (isset($_GET['user'])) {
    PersoneController::getInstance();
}
elseif(HtmlDocument::getInstance()->get('mod') == 'file') {
    $file = new File;
    HtmlDocument::getInstance()->addContent($file);
    
    $file_list = new FileList();
    HtmlDocument::getInstance()->addContent($file_list);
}
elseif(HtmlDocument::getInstance()->get('mod') == 'settings') {
    UserSettingsController::getInstance();
}
else {
    BlogController::getInstance();
}

HtmlDocument::getInstance()->printDocument();

/**
 * @todo узнать как работать с историей переходов, как в нее писать, и как
 * изменть урл страницы в адресной строке без перехода
 */

?>