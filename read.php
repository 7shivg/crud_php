<?php

$data = json_decode(file_get_contents('php://input')) ;  //the whole file is treated as string so we have to create the object of the file 
include('db.php') ;

$query = " SELECT * FROM products";

if(isset($_GET['id'])){
    $query ="SELECT * FROM products WHERE id =".$_GET["id"];
}
    $run=mysqli_query($db,$query);
    $products = mysqli_fetch_all($run,MYSQLI_ASSOC);  //from this only the vaues are visible to make it as key value pairs then we have to add  MYSQLI_ASSOC this will give the key value pairs 
    echo json_encode($products);
    
    