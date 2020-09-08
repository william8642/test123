<?php
$page_title = '新增資料';
$page_name = 'vendor-insert2';
// 與資料庫連線
require __DIR__ . '../../parts/connect_db.php';
?>
<?php require __DIR__ . '../../parts/html_head.php'; ?>

<?php include __DIR__ . '../../parts/navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div id="infobar" class="alert alert-success" role="alert" style="display: none">
                A simple success alert—check it out!
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增資料</h5>

                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <div class="form-group">
                            <label for="vendor_name"><span class="red-stars">**</span>廠商名稱</label>
                            <input type="text" class="form-control" id="vendor_name" name="vendor_name" required>
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="address"><span class="red-stars">**</span>地址</label>
                            <input type="text" class="form-control" id="address" name="address">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="TEL"><span class="red-stars">**</span>電話</label>
                            <input type="text" class="form-control" id="TEL" name="TEL">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="email"><span class="red-stars">**</span>信箱</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="tax_ID_number"><span class="red-stars">**</span>統一編號</label>
                            <input type="text" class="form-control" name="tax_ID_number" id="tax_ID_number"></input>
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="contact_person	"><span class="red-stars">**</span>聯絡人</label>
                            <input type="text" class="form-control" name="contact_person" id="contact_person"></input>
                            <small class="form-text error-msg"></small>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>






</div>
<?php include __DIR__ . '../../parts/script.php'; ?>
<script>
    // 列出正規表達式的格式
    // 檢視日期是否正確
    const email_pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    const $vendor_name = document.querySelector('#vendor_name');
    const $address = document.querySelector('#address');
    const $TEL = document.querySelector('#TEL');
    const $email= document.querySelector('#email');
    const $tax_ID_number = document.querySelector('#tax_ID_number');
    const $contact_person = document.querySelector('#contact_person');
    const r_fields = [$vendor_name, $address, $TEL, $email, $tax_ID_number,$contact_person];
    const infobar = document.querySelector('#infobar');
    const submitBtn = document.querySelector('button[type=submit]');

    function checkForm() {
        // 預設值為true
        let isPass = true;

        r_fields.forEach(el => {
            el.style.borderColor = '#CCCCCC';
            el.nextElementSibling.innerHTML = '';
        });
        // 成功送出 按鈕消失
        submitBtn.style.display = 'none';
        // TODO: 檢查資料格式
        // 檢查名字格式 小於二 提醒用戶
        if ($vendor_name.value.length < 2) {
            isPass = false;
            $vendor_name.style.borderColor = 'red';
            $vendor_name.nextElementSibling.innerHTML = '請填寫正確的公司名稱';
        }

        if(! email_pattern.test($email.value)) {
            isPass = false;
            $email.style.borderColor = 'red';
            $email.nextElementSibling.innerHTML = '請填寫正確格式';
        }


        // //   如日期不符合正規表達式 提醒用戶
        // if (!date_pattern.test($MD.value)) {
        //     isPass = false;
        //     $MD.style.borderColor = 'red';
        //     $MD.nextElementSibling.innerHTML = '請填寫正確的製造日期';
        // }
        // //   如日期不符合正規表達式 提醒用戶
        // if (!date_pattern.test($expried.value)) {
        //     isPass = false;
        //     $expried.style.borderColor = 'red';
        //     $expried.nextElementSibling.innerHTML = '請填寫正確的使用期限';
        // }

        //   如果通過檢查 利用fetch傳到後端
        if (isPass) {
            // 使用formdata把 form做成表單
            const fd = new FormData(document.form1);

            fetch('vendor-insert-api.php', {
                method: 'POST',
                body: fd
            })
                .then(r => r.json())
                .then(obj => {
                    if (obj.success) {
                        infobar.innerHTML = '新增成功';
                        infobar.className = "alert alert-success";
                        //if(infobar.classList.contains('alert-danger')){
                        //infobar.classList.replace('alert-danger', 'alert-success')
                        // }
                        setTimeout(() => {
                            location.href = 'vendor-list.php?page=1';
                        }, 3000)
                    } else {
                        infobar.innerHTML = obj.error || '新增失敗';
                        infobar.className = "alert alert-danger";
                        // if(infobar.classList.contains('alert-success')){
                        //     infobar.classList.replace('alert-success', 'alert-danger')
                        // }
                        submitBtn.style.display = 'block';
                    }
                    infobar.style.display = 'block';
                });

        } else {
            // 如果新增失敗submitBtn 會繼續留著
            submitBtn.style.display = 'block';
        }
    }
</script>
<?php include __DIR__ . '../../parts/html_foot.php'; ?>

<?php
