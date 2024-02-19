<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

error_reporting(0); // Comment out during debugging

$json = file_get_contents('php://input');
var_dump($json); // Debugging: Check if JSON data is received correctly

$data = json_decode($json); // Decode JSON data
var_dump($data); // Debugging: Check if JSON data is decoded correctly

if ($data && isset($data->id)) {
    include('db.php'); // Include database connection

    $query2 = "SELECT * FROM products WHERE id =" . $data->id;
    $run2 = mysqli_query($db, $query2);
    $product = mysqli_fetch_assoc($run2);

    if ($product) {
        $product_name = $product["product_name"];
        $product_price = $product["product_price"];
        $stock = $product["stock"];
        $discount = $product["discount"];

        // Your update logic here...
        if ($data->discount != '') {
            $discount = $data->discount;
        }
        if ($data->product_name != '') {
            $product_name = $data->product_name;
        }
        if ($data->product_price != '') {
            $product_price = $data->product_price;
        }
        if ($data->stock != '') {
            $stock = $data->stock;
        }

        $query = "UPDATE products SET ";
        $query .= "product_name='$product_name', ";
        $query .= "product_price=$product_price, ";
        $query .= "stock=$stock, ";
        $query .= "discount=$discount ";
        $query .= "WHERE id=" . $data->id;

        $run = mysqli_query($db, $query);

        if ($run) {
            echo json_encode(["status" => "success", "message" => "Product updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Product not updated: " . mysqli_error($db)]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    }
} else {
    echo json_encode(['status' => 'failed', 'msg' => 'Product ID not provided']);
}
?>
