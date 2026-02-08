<?php
include "../data/db.php";
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

/* READ - Live Search */
if ($method === "GET") {
    $search = $_GET['search'] ?? '';

    if (!empty($search)) {
        $stmt = $conn->prepare("
            SELECT * FROM inventory
            WHERE engine_number LIKE ?
               OR model LIKE ?
               OR delivery_area LIKE ?
            ORDER BY engine_number DESC
        ");
        $q = "%$search%";
        $stmt->bind_param("sss", $q, $q, $q);
        $stmt->execute();
        $res = $stmt->get_result();
    } else {
        $res = $conn->query("SELECT * FROM inventory ORDER BY engine_number DESC");
    }

    echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}

/* CREATE */
if ($method === "POST") {
    $data = json_decode(file_get_contents("php://input"), true) ?? $_POST;

    if (!empty($data)) {
        $stmt = $conn->prepare("
            INSERT INTO inventory
            (model, color, date_of_arrival, delivery_area, location_of_clearance, date_sent_out)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssss",
            $data['model'],
            $data['color'],
            $data['date_of_arrival'],
            $data['delivery_area'],
            $data['location_of_clearance'],
            $data['date_sent_out']
        );

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "engine_number" => $conn->insert_id
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => $stmt->error
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No data received"
        ]);
    }
}
