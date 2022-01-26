<?php

require_once "../functions/init.php";

if (isset($_FILES['file'])) {

    $photo = new Photo();
    $photo->__set('photo_title', 'Mountains.jpg');

    var_dump($photo);

    echo 'imagen detectada';
};
