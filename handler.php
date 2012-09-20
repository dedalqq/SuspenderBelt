<?php

include 'config.php';
include 'include/init.php';

if (isset($_GET['file_upload']) && isset($_FILES['file'])) {
    
    $group = 0;
    $file_num = count($_FILES['file']['name']);
    for($i=0; $i<$file_num; $i++) {
        $file = new File;
        
        if (!move_uploaded_file(
                $_FILES['file']['tmp_name'][$i],
                $GLOBALS['config']['file_storage'].$_FILES['file']['name'][$i].'_'.Date::now())) {
            continue;
        }
        
        $file->name = $_FILES['file']['name'][$i];
        $file->size = $_FILES['file']['size'][$i];
        $file->type = $_FILES['file']['type'][$i];
        $file->group_id = $group;
        $file->date = Date::now();
        $file->user_id = Autorisation::getInstance()->getUser()->getId();
        
        $id = $file->save();
        
        $group = ($i == 0 ? $id : $group);
        
        if ($i == 0 && $file_num > 1) {
            $file->group_id = $id;
            $file->save();
        }
        echo 'qq';
    }
    exit();
}

if (!empty($_GET['download_file'])) {
    $file = new File((int)$_GET['download_file']);
    
    $attach = !empty($_GET['get_file']) ? ' attachment;' : '';
    
    if (!empty($file->name) && $fe = fopen($GLOBALS['config']['file_storage'].$file->name.'_'.$file->date, 'r')) {
        header('Content-type: '.$file->type);
        header('Content-Disposition:'.$attach.' filename="'.$file->name.'"');
        header('Content-length: '.$file->size);
        while(!feof($fe)) {
            $content = fgets($fe);
            echo $content;
        }
    }
    fclose($fe);
    exit();
}

?>