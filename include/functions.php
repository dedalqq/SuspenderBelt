<?php

function raplace_uri_parametrs($parametrs = array(), $uri = '') {
    if ($uri == '') {
        $uri = $_SERVER['REQUEST_URI'];
    }
    if (!isset($parametrs['print_only_content'])) {
        $parametrs['print_only_content'] = '';
    }
    list($script, $parametrs_list) = explode('?', $uri);
    $parametrs_list = explode('&', $parametrs_list);
    $parametrs_array = array();
    foreach($parametrs_list as $v) {
        list($name, $value) = explode('=', $v);
        $parametrs_array[$name] = $value;
    }
    foreach($parametrs as $i => $v) {
        if ($v == '') {
            unset($parametrs_array[$i]);
        }
        else {
            $parametrs_array[$i] = $v;
        }
    }
    $result_parametrs = array();
    foreach($parametrs_array as $i => $v) {
        $result_parametrs[] = $i.'='.$v;
    }
    
    return $script.'?'.implode('&', $result_parametrs);
}

?>
