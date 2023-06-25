<?php

//register_shutdown_function(function () {
//    var_dump(error_get_last());
//    die;
//});

use App\service\Constants;

require_once "bootstrap.php";

try {
    $controller = "\App\controller\\" . $_GET["act"] . "Controller";
    $method = new $controller();
    $response = $method->{$_GET["method"]}($_REQUEST);
    if ($response != null) {
        outputJson(true, $response, Constants::OK_REQUEST_CODE);
    }
} catch (Exception $e) {
    outputJson(false, $e->getMessage(), $e->getCode());
} catch (Error $e) {
    outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
}