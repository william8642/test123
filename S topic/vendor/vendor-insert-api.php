<?php

require __DIR__ . '../../parts/connect_db.php';

// 收到前端網頁的input後 給一個回應
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];
// 檢查 產品名稱
//INSERT INTO `vendor-list`(`sid`, `vendor_name`, `address`, `TEL`, `email`, `tax_ID_number`,
if (mb_strlen($_POST['vendor_name']) < 2) {
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


// 檢查 日期格式

// 如檢查格式無誤 使用mysql語法 寫入資料庫
$sql = "INSERT INTO `vendor-list`( `vendor_name`, `address`, `TEL`, `email`, `tax_ID_number`,`contact_person`) 
VALUES (?,?,?,?,?,?)";

// 注意大小寫 嚴格區分大小寫
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['vendor_name'],
    $_POST['address'],
    $_POST['TEL'],
    $_POST['email'],
    $_POST['tax_ID_number'],
    $_POST['contact_person']
]);
// 回傳一個成功 主要是用來控制 對話框的樣式 如果回傳成功 會跳出 新增成功(把display:none 改成 block)
if ($stmt->rowCount()) {
    $output['success'] = true;
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
