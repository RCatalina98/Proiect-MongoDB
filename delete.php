<?php
 //include connection file
 include "Connection.php";

  $bulk = new MongoDB\Driver\BulkWrite;
$id = new \MongoDB\BSON\ObjectId($_GET['id']);
$filter = ['_id' => $id];

$bulk->delete($filter);

$client->executeBulkWrite('images.images',$bulk);

 
header('location:sale.php');



 ?>