<?php

function classAutoLoader($class)
{
    $class = strtolower($class);

    $path = "functions/{$class}.php";

    if (is_file($path) && !class_exists($class)) {
        include $path;
    }
}

spl_autoload_register('classAutoLoader');

function redirect($location)
{
    header("Location: {$location}");
}
