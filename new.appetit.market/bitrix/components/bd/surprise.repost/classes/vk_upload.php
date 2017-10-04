<?php
if (isset($_POST["url"])) {
 
    $upload_url = $_POST["url"];
 
    $post_params['photo'] = '@'.$_SERVER['DOCUMENT_ROOT'].$_POST['photo']; 

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $upload_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
    $result = curl_exec($ch);
    curl_close($ch);
 
    echo $result;
 
}