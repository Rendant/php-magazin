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


    $sql = sprintf('SELECT id, `login` FROM users WHERE login LIKE \'%s\' AND passw LIKE \'%s\'', $login, $pass);
    $result = '{"user":';
    $stmt = $db->query($sql)->fetch();
    if (isset($stmt['id'])) {
        $id = $stmt['id'];
        $token = md5(time());
        $expiration = time() + 48*60*60;
        $result .= sprintf('{"id":%d, "token":"%s", "expired":%d}', $id, $token, $expiration);
        $result .= '}';

        $sql = sprintf("UPDATE users SET token = '%s', expired = FROM_UNIXTIME(%d) WHERE id = %d", $token, $expiration, $id);
        $db->exec($sql);
    }
    else {
        $result = '{"error": {"text": "Неверный логин/пароль"}}';
    }
}
else {
    $result = '{"error": {"text": "Не передан логин/пароль"}}';
}
echo $result;
?>