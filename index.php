<?php

require "system/Routing.php";
include_once 'server/DataAccess/DB.php';

$db = new DB();
$urls = $db->Select("SELECT url_card FROM product");
$data = array();

while ($row = sqlsrv_fetch_array($urls, SQLSRV_FETCH_ASSOC)) {
    array_push($data, $row);
}
$db->CloseConnection();

$url = key($_GET);
$router = new Routing();

$router->AddRoute("/", "AddProductPage.php");
$router->AddRoute("/List", "ListProducts.php");

foreach ($data as $item) {
    $router->AddRoute("/view/" . explode("/", $item["url_card"])[count(explode("/", $item["url_card"])) - 1], "View.php");
}

foreach ($data as $item) {
    $router->AddRoute("/edit/" . explode("/", $item["url_card"])[count(explode("/", $item["url_card"])) - 1], "Edit.php");
}


$router->Route("/" . $url);