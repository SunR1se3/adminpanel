<?php

$serverName = "localhost"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"AdminPanel");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if( $conn ) {
    echo "Connection established.<br />";
}else{
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}

$sql_category = "CREATE TABLE category (
    id int NOT NULL,
    title varchar(50) NOT NULL,
    CONSTRAINT pk_category PRIMARY KEY (id)
)";

$sql_brand = "CREATE TABLE brand (
    id int NOT NULL,
    title varchar(50) NOT NULL,
    CONSTRAINT pk_brand PRIMARY KEY (id)
)";

$sql_product = "CREATE TABLE product (
    id int NOT NULL IDENTITY(1,1),
    title varchar(50) NOT NULL,
    description varchar(100) NOT NULL,
    photo varchar(150) NOT NULL,
    url_card varchar(150) NOT NULL,
    price decimal NOT NULL,
    status tinyint NOT NULL,
    categoryId int NOT NULL, 
    brandId int NOT NULL, 
    CONSTRAINT pk_product PRIMARY KEY (id),
    CONSTRAINT fk_brand FOREIGN KEY (brandId) REFERENCES brand(id),
    CONSTRAINT fk_category FOREIGN KEY (categoryId) REFERENCES category(id),
)";

$sql_add = "INSERT INTO product VALUES (1, 'Продукт 1', 'Описание 1', 'фотка 1', 'урл карточки', 100, 1, 1, 5)";
$stmt = sqlsrv_query($conn, $sql_product);
if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}
//$sql_add = "SELECT * FROM category";


//while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
//    print_r($row);
//}

var_dump($stmt);