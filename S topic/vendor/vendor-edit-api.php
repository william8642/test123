<?php

require __DIR__ . '../../parts/connect_db.php';

// 收到前端網頁的input後 給一個回應
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

if (empty($_POST['sid'])) {
    $output['code'] = 405;
    $output['error'] = '沒有 sid';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
// 檢查 產品名稱
if (mb_strlen($_POST['name']) < 2) {
    $output['code'] = 401;
    $output['error'] = '產品名稱長度要大於 2';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match('/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i', $_POST['email'])) {
    $output['code'] = 420;
    $output['error'] = 'email格式錯誤';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
//// 檢查 日期格式
//if (!preg_match('/^[1-9]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $_POST['MD'])) {
//    $output['code'] = 420;
//    $output['error'] = '日期格式錯誤';
//    echo json_encode($output, JSON_UNESCAPED_UNICODE);
//    exit;
//}
//if (!preg_match('/^[1-9]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $_POST['expried'])) {
//    $output['code'] = 420;
//    $output['error'] = '日期格式錯誤';
//    echo json_encode($output, JSON_UNESCAPED_UNICODE);
//    exit;
//}
// `sid`, `name`, `price`, `MD`, `expried`, `firm`SELECT * FROM `shop_list` WHERE 1
// 如檢查格式無誤 使用mysql語法 寫入資料庫
$sql = "UPDATE `vendor-list` SET 

    `address`=?,
    `TEL`=?,
    `email`=?,
    `tax_ID_number`=?,
    `contact_person`=?,
    WHERE `vendorname`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([

    $_POST['address'],
    $_POST['TEL'],
    $_POST['email'],
    $_POST['tax_ID_number'],
    $_POST['contact_person'],
    $_POST['vendor_name'],
]);
// 回傳一個成功 主要是用來控制 對話框的樣式 如果回傳成功 會跳出 新增成功(把display:none 改成 block)
if ($stmt->rowCount()) {
    $output['success'] = true;
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);

