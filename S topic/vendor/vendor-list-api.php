<?php

require __DIR__ . '../../parts/connect_db.php';

$perPage = 5; // 每頁有幾筆資料
// 如果用戶有輸入就跳到用戶輸入的頁數 沒有輸入 就跳到第一頁
$output = [
    'perPage' => $perPage,
    'totalRows' => 0,
    'totalPages' => 0,
    'page' => 0,
    'rows' => [],
];
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
// 到shoplist撈資料
$t_sql = "SELECT COUNT(1) FROM `vendor-list`";
// 總共有幾筆
$output['totalRows'] = $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
// 總頁數= 總比數 除以一頁有幾筆
$output['totalPages'] = $totalPages = ceil($totalRows / $perPage);


// 如果撈到的總筆數大於0 
if ($totalRows > 0) {
    // 如果用戶輸入小於1 跳轉到第一頁
    if ($page < 1) {
        $page = 1;
    }
    // 如果用戶輸入的頁數 大於 總頁數 跳轉到最後一頁 用.去串接 $totalPages 相當於js +號的字串相接
    if ($page > $totalPages) {
        $page = $totalPages;
    };
    $output['page']  = $page;                           //從0開始 拿五筆
    // sql = 篩選到 全部的資料    第一頁 LIMIT = 1-1*5 拿五筆 =0~5 以此類推
    $sql = sprintf("SELECT * FROM `vendor-list` ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    //stmt = 拿sql 的 筆數  (ex limit 0,5 從第0筆開始 撈五筆)  
    $stmt = $pdo->query($sql);
    // 把他塞到 rows 裡面 然後 下面利用foreach呈現在表格上
    $output['rows'] = $stmt->fetchAll();
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);