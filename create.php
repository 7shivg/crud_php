<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Method:POST');
header('Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Autherizatio,X-Request-With ');
error_reporting(0);
$data = json_decode(file_get_contents('php://input')) ;  //the whole file is treated as string so we have to create the object of the file 
include('db.php') ;

if($data->discount==''){
    echo json_encode(['status'=> 'failed','msg'=> 'discount Not provided']);
}else if( $data->product_name   == ''){
    echo json_encode(['status'=> 'failed','msg'=> 'product_name Not provided']);
}else if( $data->product_price == ''){
    echo json_encode(['status'=> 'failed', 'msg'=>'product_price not provided']);
}
else if( $data->stock == ''){
    echo json_encode(['status'=> 'failed', 'msg'=>'stock not provided']);
}
else{

    $query="INSERT INTO products(product_name,product_price,stock,discount)";
    $query.="VALUES('$data->product_name','$data->product_price','$data->stock','$data->discount')";
    
    $run=mysqli_query($db,$query);
    
    if($run){
        echo json_encode(["status"=> "success","message"=> "product added"]);
    }
    else{
        echo json_encode(["status"=> "error","message"=> "product not added"]);
    }
}