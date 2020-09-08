<?php
$page_title = '登入';
$page_name = 'login';
require __DIR__ . '/parts/connect_db.php';
?>
<?php require __DIR__ . '/parts/html_head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>



    <body>
<div class="container">

    <div class="row">
        <div class="col-lg-6">

            <form method="post" name="form1" onsubmit="checkForm(); return false;">
                <div class="form-group">
                    <label for="account">Account</label>
                    <input type="text" class="form-control" id="account" name="account">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>
<?php include __DIR__ . '/parts/script.php'; ?>
<script>
    function checkForm() {
        // 把用戶輸入的資料 轉json傳到api / 再讓api用mysql語法跟資料庫 做比對 如果 帳密都正確就 設置一個session
        const fd = new FormData(document.form1);
        fetch('login-api.php', {
            method: 'POST',
            body: fd
        })
            .then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert('登入成功');
                    location.href = 'vendor-list.php';
                } else {
                    alert('登入失敗');
                }
            });


    }
</script>
<?php include __DIR__ . '/parts/html_foot.php'; ?>