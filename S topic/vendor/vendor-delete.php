<?php
require __DIR__ . '../../parts/connect_db.php';
// $referer 代表你從哪裡連過來的(上一頁)      (這是語法) 如過有設定'HTTP_REFERER' 就返回上一頁 沒有就回到list列表
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'vendor-list.php';
// 如果沒給 刪除的sid 就返回上一頁
if (empty($_GET['sid'])) {
    header('Location: ' . $referer);
    exit;
}
// 強制把她轉換成數字 無法轉換的話給  0
$sid = intval($_GET['sid']) ?? 0;
// sql刪除語法
$pdo->query("DELETE FROM `vendor-list`WHERE sid=$sid ");
// 然後返回上一頁
header('Location: ' . $referer);