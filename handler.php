<?php

include 'config.php';
include 'include/init.php';

if (!empty($_POST['get_preview'])) {
    $file = new File((int)$_POST['file_id']);
    echo $file->getPreview(true);
}
elseif (!empty($_GET['download_file'])) {
    $file = new File((int)$_GET['download_file']);
    
    $attach = !empty($_GET['get_file']) ? ' attachment;' : '';
    
    $typs_for_preview = array('image/jpeg', 'image/png');
    
    if (!empty($file->name)) {
        
        header('Content-type: '.$file->type);
        header('Content-Disposition:'.$attach.' filename="'.$file->name.'"');
        
        if (!empty($_GET['preview']) && in_array($file->type, $typs_for_preview)) {
            
            $height = (int)$_GET['preview'];
            $image = new Imagick($GLOBALS['config']['file_storage'].$file->name.'_'.$file->date);
            $imageprops = $image->getImageGeometry();
            
            if ($imageprops['height'] > $height) {
                $width = $imageprops['width']/$imageprops['height']*$height;
                $image->resizeImage($width, $height, imagick::FILTER_LANCZOS, 0.9, true);
            }
            /**
            * @todo помоему strlen это как то кривоватенько 0_о" 
            */
            header('Content-length: '.strlen((string)$image));
            echo $image;
            $file->download_num++;
            $file->save();
            exit();
        }
        elseif ($fe = fopen($GLOBALS['config']['file_storage'].$file->name.'_'.$file->date, 'r')) {
            header('Content-length: '.$file->size);
            while(!feof($fe)) {
                $content = fgets($fe);
                echo $content;
            }
            fclose($fe);
            $file->download_num++;
            $file->save();
            exit();
        }
    }
}
else {
    phpinfo();
}
?>