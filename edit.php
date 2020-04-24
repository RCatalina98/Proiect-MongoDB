<!DOCTYPE HTML>
<html>

<head>
  <title>EDIT</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
  
    
 <?php       
//include connection file
     require_once 'Connection.php';
        $bulk = new MongoDB\Driver\BulkWrite;
        
        if(!isset($_POST["submit"])){
            $id = new \MongoDB\BSON\ObjectId($_GET['id']);
            $filter = ['_id' => $id];
            $query = new MongoDB\Driver\Query($filter);          
            $article = $client->executeQuery("images.images", $query);
            $doc = current($article->toArray());
            }else{
                if($_FILES["image"]['name']>0){
             $target="./images/".md5(uniqid(time())).basename($_FILES['image']['name']);
                }else{
                    $ids = new \MongoDB\BSON\ObjectId($_POST['id']);
$filters = ['_id' => $ids];
$querys = new MongoDB\Driver\Query($filters);          
$articles = $client->executeQuery('images.images', $querys);
$docs = current($articles->toArray());
           $target=$docs->image;
           echo $target;
           }  
                
 $data=[
        'title'=>$_POST['title'],
        'image'=>$target
    ];
 $id = new \MongoDB\BSON\ObjectId($_POST['id']);
$filter = ['_id' => $id];
$update=['$set'=>$data];
 $bulk->update($filter, $update);
 $client->executeBulkWrite('images.images',$bulk);           
            
   move_uploaded_file($_FILES['image']['tmp_name'],$target);
          header('Location:sale.php');
            
        }   
 ?>        
<h1>Edit:</h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
    Title:<br/><input type="text" name="title" value="<?php echo $doc->title ;?>"/><br/>
    Image: <br/><input type="file" name="image" value="<?php echo $doc->image ;?>"><br/>
    <img src="<?php echo $doc->image ;?>"><br/>
    <input type="hidden" name="id" value="<?php echo $doc->_id; ?>"/>
    <input type="submit" name="submit" value="Edit"/>
</form>
</body>
</html>