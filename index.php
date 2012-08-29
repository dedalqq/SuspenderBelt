<?php

include 'config.php';
include 'include/init.php';

HtmlDocument::getInstance()->PageHeader->addMenuElement('blog', '����');
HtmlDocument::getInstance()->PageHeader->addMenuElement('log', '����');

HtmlDocument::getInstance()->PageMenu->menuOn();

if (isset($_GET['autorisation'])) {
    Autorisation::getInstance()->controller();
}
elseif (isset($_GET['user'])) {
    PersoneController::getInstance();
}
else {
    BlogController::getInstance();
}

HtmlDocument::getInstance()->printDocument();

?>