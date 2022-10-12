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
echo '<table border="2">';
	echo '<tr>';
		echo '<td>id</td>';
		echo '<td>title</td>';
		echo '<td>description</td>';
		echo '<td>price</td>';
		echo '<td>count</td>';
		echo '<td>cat_name</td>';
	echo '</tr>';
while ($row = $stmt->fetch()) {
	echo '<tr>';
		echo '<td>'.$row['id'].'</td>';
		echo '<td>'.$row['title'].'</td>';
		echo '<td>'.$row['description'].'</td>';
		echo '<td>'.$row['price'].'</td>';
		echo '<td>'.$row['count'].'</td>';
		echo '<td>'.$row['c_title'].'</td>';
	echo '</tr>';
}
echo '</table>';
?>