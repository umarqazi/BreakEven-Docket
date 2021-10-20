<?php

function dd($data=null){
    if (!empty($data)) {
        echo '<pre>';
        print_r($data);
        die();
    } else {
        die();
    }
}

function bb($data=null){
    if (!empty($data)) {
        echo '<pre>';
        print_r($data);
    }
}
?>