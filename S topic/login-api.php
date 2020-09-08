<?php
require __DIR__ . '/parts/connect_db.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

$account = isset($_POST['account']) ? $_POST['account'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$sql = "SELECT `sid`, `account`, `nickname` 
        FROM `william` 
        WHERE `account`=? AND `password`=?";
// 如果帳號密碼都正確sql就會rowcount就會有東西 代表登入成功了
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $account,
    $password,
]);
// 設置一個session
if ($stmt->rowCount()) {
    $output['success'] = true;
    $_SESSION['admin'] = $stmt->fetch();
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
