<?php
include "../data/db.php";

class InventoryService {

    public function getAll() {
        global $conn;
        $res = $conn->query("SELECT * FROM inventory");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function search($keyword) {
        global $conn;
        $stmt = $conn->prepare("
            SELECT * FROM inventory
            WHERE model LIKE ? OR delivery_area LIKE ?
        ");
        $q = "%$keyword%";
        $stmt->bind_param("ss",$q,$q);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

$server = new SoapServer(null, ['uri'=>"http://localhost/soap"]);
$server->setClass("InventoryService");
$server->handle();
