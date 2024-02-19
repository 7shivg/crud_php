<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// error_reporting(0); // Comment out during debugging

$data = json_decode(file_get_contents('php://input')); // Decode JSON data

if ($data && isset($data->id)) {
    include('db.php'); // Include database connection

    $query = "DELETE FROM products WHERE id = " . $data->id;
    $run = mysqli_query($db, $query);

    if ($run) {
        echo json_encode(["status" => "success", "message" => "Product deleted"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Product not deleted: " . mysqli_error($db)]);
    }
} else {
    echo json_encode(['status' => 'failed', 'msg' => 'Product ID not provided']);
}
?>
