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
if (!empty($_GET['l'] && !empty($_GET['p']))) {
    $login = $_GET['l'];
    $pass = $_GET['p'];

    $sql = sprintf('SELECT id FROM users WHERE `login`=\'%s\'', $login);
    $stmt = $db->query($sql)->fetch();
    if ($stmt) {
        $result = '{"error": {"text": "Такой логин уже занят"}}';
    }
    else {
        $token = md5(time());
        $expiration = time() + 48*60*60;
        $sql = sprintf('INSERT INTO users SET `login`=\'%s\', passw=\'%s\', token=\'%s\', expired=FROM_UNIXTIME(%d)', $login, $pass, $token, $expiration);
        $db->exec($sql);

        $sql = sprintf('SELECT id FROM users WHERE `login`=\'%s\'', $login);
        $stmt = $db->query($sql);
        while ($row = $stmt->fetch()) {
            $result = '{"user": {"id": '.$row['id'].'}}';
        }
    }
}
else {
    $result = '{"error": {"text": "Не передан логин/пароль"}}';
}
echo $result;
?>