<?php

include_once 'DataAccess/DB.php';

class CategoryService {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function GetAll() {
        $stmt = $this->db->Select("SELECT * FROM category");
        $data = array();

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            array_push($data, $row);
        }
        $this->db->CloseConnection();
        return $data;
    }
}

$categoryService = new CategoryService();
$data_category = $categoryService->GetAll();