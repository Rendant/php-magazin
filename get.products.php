<?php
$host = 'db';
$db_name = 'testdb';
$db_user = 'root';
$db_pas = '1234';

try {
    $db = new PDO('mysql:host='.$host.';dbname='.$db_name,$db_user,$db_pas);
}
catch (PDOException $e) {
    print "error: " . $e->getMessage();
    die();
}
$stmt = $db->query("SELECT t.id, t.title, description, price, count, k.title as c_title FROM products AS t JOIN categories AS k on t.id_cat=k.id");
$result = '{"response":[';
while ($row = $stmt->fetch()) {
	$result .= '{';
		$result .= '"id":'.$row['id'].',"title":"'.$row['title'].'","descrpition":"'.$row['description'].'","price":'.$row['price'].',"count":'.$row['count'].',"cat_name":"'.$row['c_title'].'"';
	$result .= '},';
}
$result = rtrim($result, ",");
$result .= ']}';
echo $result;
?>