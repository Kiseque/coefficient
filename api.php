<?php

//register_shutdown_function(function () {
//    var_dump(error_get_last());
//    die;
//});

require_once "bootstrap.php";

try {
    $controller = "\App\controller\\" . $_GET["act"] . "Controller";
    $method = new $controller();
    $response = $method->{$_GET["method"]}($_REQUEST);
    if ($response != null) {
        outputJson(true, $response, 200);
    }
} catch (Exception $e) {
    outputJson(false, $e->getMessage(), $e->getCode());
} catch (Error $e) {
    outputJson(false, 'Bad request', 400);
}