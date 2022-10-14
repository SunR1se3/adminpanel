<?php

include_once 'DataAccess/DB.php';

class ProductService {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function AddData($data) {
        $data["photo"] = 'img/' . $_FILES['photo']['name'];
        $sql = "INSERT INTO product VALUES ('$data[title]', '$data[description]', '$data[photo]', '$data[url_card]', $data[price], $data[status], $data[categoryId], $data[brandId])";
        $this->db->SqlExec($sql);

        $target = 'img/' . $_FILES['photo']['name'];
        move_uploaded_file( $_FILES['photo']['tmp_name'], $target);

        $this->db->CloseConnection();


    }

    public function GetAll() {
        $stmt = $this->db->Select("SELECT p.id, p.title, p.description, p.photo, p.url_card, p.price, p.status, c.title as title_catgory, b.title as title_brand FROM product p, brand b, category c WHERE p.categoryId=c.id AND p.brandId=b.id;");
        $data = array();

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($data, $row);
        }
        $this->db->CloseConnection();
        return $data;
    }

    public function RemoveById($id) {
        $sql = "DELETE FROM product WHERE id=$id";
        $this->db->SqlExec($sql);
        $this->db->CloseConnection();
    }

    public function UpdateById($id, $status) {
        $sql = "UPDATE product SET status=$status WHERE id=$id";
        $this->db->SqlExec($sql);
        $this->db->CloseConnection();
    }

    public  function  GetByUrl($url) {
        $stmt = $this->db->Select("SELECT p.id, p.title, p.description, p.photo, p.url_card, p.price, p.status, c.title as title_catgory, b.title as title_brand FROM product p, brand b, category c WHERE p.categoryId=c.id AND p.brandId=b.id AND p.url_card='$url'");
        $data = array();

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($data, $row);
        }
        return $data;
    }

    public function UpdateAllData($data) {
        if (!$_FILES['photo']['name']) {
            $sql = "UPDATE product SET title='$data[title]', description='$data[description]', url_card='$data[url_card]', price=$data[price], status=$data[status], categoryId=$data[categoryId], brandId=$data[brandId] WHERE id=$data[id]";
        } else {
            $data["photo"] = 'img/' . $_FILES['photo']['name'];
            $sql = "UPDATE product SET title='$data[title]', description='$data[description]', photo='$data[photo]', url_card='$data[url_card]', price=$data[price], status=$data[status], categoryId=$data[categoryId], brandId=$data[brandId] WHERE id=$data[id]";
            $target = 'img/' . $_FILES['photo']['name'];
            move_uploaded_file( $_FILES['photo']['tmp_name'], $target);
        }
        $this->db->SqlExec($sql);

        $this->db->CloseConnection();
    }

    public function GetSearchedData($params) {
        if (array_key_exists("title", $params)) { $params['p.title'] = $params['title']; unset($params['title']); }
        $search_string = "";
        foreach ($params as $key => $value) {
            if ($key != "price_start" && $key != "price_end" && $key != "brandId" && $key != "categoryId") {
                if (is_numeric($value)) $search_string .= $key . "=$value AND "; else $search_string .= $key . "='$value' AND ";
            }
        }

        if (array_key_exists("brandId", $params) && array_key_exists("categoryId", $params)) {
            $search_string .= "b.id=$params[brandId] AND c.id=$params[categoryId] AND p.categoryId=c.id AND p.brandId=b.id AND ";
        } elseif (array_key_exists("brandId", $params) && !array_key_exists("categoryId", $params)) {
            $search_string .= "b.id=$params[brandId] AND p.brandId=b.id AND p.categoryId=c.id AND ";
        } elseif (!array_key_exists("brandId", $params) && array_key_exists("categoryId", $params)) {
            $search_string .= "c.id=$params[categoryId] AND p.categoryId=c.id AND p.brandId=b.id AND ";
        } else {
            $search_string .= "p.categoryId=c.id AND p.brandId=b.id AND ";
        }

        if (array_key_exists("price_start", $params) && array_key_exists("price_end", $params)) {
            $search_string .= "price BETWEEN $params[price_start] AND $params[price_end]";
        } elseif (array_key_exists("price_start", $params) && !array_key_exists("price_end", $params)) {
            $search_string .= "price >= $params[price_start]";
        } elseif (!array_key_exists("price_start", $params) && array_key_exists("price_end", $params)) {
            $search_string .= "price <= $params[price_end]";
        } else {
            $search_string = mb_substr($search_string, 0, -5);
        }

        $stmt = $this->db->Select("SELECT p.id, p.title, p.description, p.photo, p.url_card, p.price, p.status, c.title as title_catgory, b.title as title_brand FROM product p, brand b, category c WHERE " . $search_string);
        $data = array();

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($data, $row);
        }
        return $data;
    }

    public function getDataOrderByPrice() {
        $stmt = $this->db->Select("SELECT p.id, p.title, p.description, p.photo, p.url_card, p.price, p.status, c.title as title_catgory, b.title as title_brand FROM product p, brand b, category c WHERE p.categoryId=c.id AND p.brandId=b.id ORDER BY p.price");
        $data = array();

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($data, $row);
        }
        return $data;
    }

    public function getDataOrderByTitle() {
        $stmt = $this->db->Select("SELECT p.id, p.title, p.description, p.photo, p.url_card, p.price, p.status, c.title as title_catgory, b.title as title_brand FROM product p, brand b, category c WHERE p.categoryId=c.id AND p.brandId=b.id ORDER BY p.title");
        $data = array();

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($data, $row);
        }
        return $data;
    }

}

$productService = new ProductService();

$data = array();

$action = "";

if (count($_POST) > 0) {
    if (array_key_exists("delete", $_POST)) $action = "delete";
    if (array_key_exists("changeStatus", $_POST)) $action = "changeStatus";
    if (array_key_exists("updateData", $_POST)) $action = "updateData";
    if (array_key_exists("getSearchedData", $_POST)) $action = "getSearchedData";
    if (array_key_exists("sortPrice", $_POST)) $action = "sortPrice";
    if (array_key_exists("sortTitle", $_POST)) $action = "sortTitle";
    switch ($action) {
        case "delete":
            $productService->RemoveById($_POST["id"]);
            break;
        case "changeStatus":
            $productService->UpdateById($_POST["id"], $_POST["status"]);
            break;
        case  "updateData":
            $productService->UpdateAllData($_POST);
            break;
        case "getSearchedData":
            unset($_POST['getSearchedData']);
            $data = $productService->GetSearchedData($_POST);
            echo json_encode($data, true);
            break;
        case "sortPrice":
            $data = $productService->getDataOrderByPrice();
            echo json_encode($data, true);
            break;
        case "sortTitle":
            $data = $productService->getDataOrderByTitle();
            echo json_encode($data, true);
            break;
        default:
            $productService->AddData($_POST);
            break;
    }
//    if (array_key_exists("delete", $_POST)) $productService->RemoveById($_POST["id"]);
//    if (array_key_exists("changeStatus", $_POST)) $productService->UpdateById($_POST["id"], $_POST["status"]);
//    if (array_key_exists("updateData", $_POST)) { $productService->UpdateAllData($_POST); }
//    else $productService->AddData($_POST);
} else {
    if (array_key_exists("getByUrl", $_GET)) $action = "getByUrl";
    if (array_key_exists("getForEdit", $_GET)) $action = "getForEdit";
    switch ($action) {
        case "getByUrl":
            $data = $productService->GetByUrl($_GET["getByUrl"]);
            break;
        case "getForEdit":
            $data = $productService->GetByUrl($_GET["getForEdit"]);
            break;
        default:
            $data = $productService->GetAll();
            break;
    }
}
//    if (array_key_exists("getByUrl", $_GET)) { $data = $productService->GetByUrl($_GET["getByUrl"]); var_dump($data); }
//    if (array_key_exists("getForEdit", $_GET)) $data = $productService->GetByUrl($_GET["getForEdit"]);
//    e
