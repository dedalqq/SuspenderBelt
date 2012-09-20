<?php

include 'config.php';
include 'include/init.php';

HtmlDocument::getInstance()->PageHeader->addMenuElement('blog', 'Блог');
HtmlDocument::getInstance()->PageHeader->addMenuElement('log', 'Логи');

HtmlDocument::getInstance()->PageHeader->addMenuElementRight('file', 'Файлы');

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
    
    $file2 = new File(8);
    
    HtmlDocument::getInstance()->addContent($file2->getLink(true));
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