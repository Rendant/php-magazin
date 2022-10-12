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
$result = '';
if (isset($_GET['tk'])) {
    $token = $_GET['tk'];
    $sql = sprintf('SELECT id FROM users WHERE token LIKE \'%s\' AND expired > CURRENT_TIMESTAMP', $token);
    $stmt = $db->query($sql)->fetch();
    if (isset($stmt['id'])) {
        $id_user = $stmt['id'];
        $sql = sprintf('SELECT t.id, t.title, t.description, t.price, k.count, cat.title AS c_title FROM cart AS k JOIN products AS t ON k.id_product = t.id JOIN categories AS cat ON t.id_cat = cat.id WHERE id_user = %d', $id_user);
        $stmt = $db->query($sql);
        $result = '{"cart":[';
        while ($row = $stmt->fetch()) {
            $result .= '{';
                $result .= '"id":'.$row['id'].',"title":"'.$row['title'].'","descrpition":"'.$row['description'].'","price":'.$row['price'].',"count":'.$row['count'].',"cat_name":"'.$row['c_title'].'"';
            $result .= '},';
        }
        $result = rtrim($result, ",");
        $result .= ']}';
    }
    else {
        $result = '{"error": {"text": "Не передан токен"}}';
    }
}
else {
    $result = '{"error": {"text": "Не передан токен"}}';
}
echo $result;
?>