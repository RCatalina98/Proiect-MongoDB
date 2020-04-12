    <?php
include'Connection.php';
require_once 'Connection.php';
$id = new \MongoDB\BSON\ObjectId($_GET['id']);
$filter = ['_id' => $id];
$query = new MongoDB\Driver\Query($filter);          
$article = $client->executeQuery("images.images", $query);
$doc = current($article->toArray());
echo "Nume: ".$doc->title."<br>";
echo "Image:<img src=".$doc->image."><br/>";
?>