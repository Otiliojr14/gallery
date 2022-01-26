<?php

require_once "../functions/init.php";

if (isset($_POST)) {
    $user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];


    $user = User::verify_user($user, $password);

    if ($user) {
        $session->login($user);
        $response = array(
            'response' => 'correct'
        );
    } else {
        $response = array(
            'response' => 'incorrect'
        );
    }


    echo json_encode($response);
}
