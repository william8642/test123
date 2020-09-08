<?php

$page_name = 'vendor-list';
require __DIR__ . '../../parts/connect_db.php';
?>
<?php require __DIR__ . '../../parts/html_head.php'; ?>
<?php include __DIR__ . '../../parts/navbar.php'; ?>

    <div class="container">

<!--        <button type="button" style="background-color: #26453D" class="btn btn-info mt-1 --><?//= $page_name == 'vendor-list' ? 'active' : '' ?><!--"><a href="vendor-list.php">廠商列表</a></button>-->
<!--        <button type="button" class="btn btn-info mt-1 --><?//= $page_name == 'vendor-insert2' ? 'active' : '' ?><!--"><a href="vendor-insert2.php">加入廠商</a></button>-->



    <div class="row">
        <table class="table table-striped">

            <thead>
            <tr>
                <th scope="col"><i class="fas fa-trash-alt"></i></th>
                <th scope="col">#</th>
                <th scope="col">廠商名稱</th>
                <th scope="col">地址</th>
                <th scope="col">電話</th>
                <th scope="col">信箱</th>
                <th scope="col">統一編號</th>
                <th scope="col">聯絡人</th>
            </tr>
            </thead>
    </div>
            <tbody>


            </tbody>
        </table>
        <div class="row">
            <div class="col d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">


                    </ul>
                </nav>

            </div>
        </div>
    </div>


    <?php include __DIR__ . '../../parts/script.php'; ?>
    <script>
        const tbody = document.querySelector('tbody')
        let pageData;
        const hashHandler = function() {
            // 不要#字號 所以從 索引1 開始切 (location  是指 網站的url)
            // 如果轉換為數字是 nan 就 設定為 1
            let h = parseInt(location.hash.slice(1)) || 1;
            if (h < 1) h = 1

            getData(h)
        }


        window.addEventListener('hashchange', hashHandler)

        hashHandler(); //頁面一進來 直接呼叫

        const pageItemTpl = (obj) => {
            // 設置一個 pageItemTpl 函數 顯示按鈕
            return `<li class="page-item ${obj.active}">
                    <a class="page-link" href="#${obj.page}">${obj.page}</a>
                    </li>`
        }

        const tableRowTpl = (obj) => {
            // 設置一個tableRowTpl 顯示 表格的內容
            return `

                    <tr>
                    <td><a href="vendor-delete.php?sid=${obj.sid}" onclick="ifDel(event)" data-sid="${obj.sid}">
                    <i class="fas fa-trash-alt"></i>
                </a></td>
                <td>${obj.sid}</td>
                <td>${obj.vendor_name}</td>
                <td>${obj.address}</td>
                <td>${obj.TEL}</td>
                <td>${obj.email}</td>
                <td>${obj.tax_ID_number}</td>
                <td>${obj.contact_person}</td>
                <td><a href="vendor-edit.php?sid=${obj.sid}"><i class="fas fa-edit"></i></a></td>


                `;
        };

        function ifDel(event) {
            const a = event.currentTarget;
            console.log(event.target, event.currentTarget);
            const sid = a.getAttribute('data-sid');
            if (!confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
                event.preventDefault(); // 取消連往 href 的設定
            }
        }
        //   預設值
        function getData(page = 1) {
            fetch('vendor-list-api.php?page=' + page)
                .then(r => r.json())
                .then(obj => {
                        console.log(obj);
                        pageData = obj;

                        let str = '';
                        for (let i of obj.rows) {
                            // 用for迴圈 把fetch 接收到的rows 資料 遍歷出來 放入tableRowTpl中
                            str += tableRowTpl(i);
                        }
                        tbody.innerHTML = str;
                        // 把str 塞到 tbody裡
                        str = '';
                        if (obj.page === 1) {
                            // 如果是在第一頁 按鈕就不能按
                            str += `<li class="page-item  disabled">
                    <a class="page-link" href="#${obj.page}">第一頁</a>
                    </li>`
                        } else {
                            str += `<li class="page-item ">
                    <a class="page-link" href="#${obj.page==1}">第一頁</a>
                    </li>`
                        }


                        if (obj.page === 1) {
                            // 如果是在第一頁 按鈕就不能按
                            str += `<li class="page-item  disabled">
                    <a class="page-link" href="#${obj.page-1}">上一頁</a>
                    </li>`
                        } else {
                            str += `<li class="page-item ">
                    <a class="page-link" href="#${obj.page-1}">上一頁</a>
                    </li>`
                        }



                        for (let i = obj.page - 3; i <= obj.page + 3; i++) {
                            // 用for迴圈 把 fetch接收到的page資料 資料 遍歷出來 放入pageItemTpl中
                            if (i < 1) continue;
                            if (i > obj.totalPages) continue;
                            // 設置一個o 物件 把 page 塞進去  這邊的功能是用來判斷是否 進入active狀態
                            const o = {
                                page: i,
                                active: ''
                            }
                            if (obj.page === i) {
                                o.active = 'active';
                            }
                            str += pageItemTpl(o);
                        }

                        if (obj.page === obj.totalPages) {
                            // 如果是在最後一頁 按鈕就不能按
                            str += `<li class="page-item  disabled">
                    <a class="page-link" href="#${obj.page}">下一頁</a>
                    </li>`
                        } else {
                            str += `<li class="page-item ">
                    <a class="page-link" href="#${obj.page+1}">下一頁</a>
                    </li>`
                        }
                        // 如果是在最後一頁 按鈕就不能按
                        if (obj.page === obj.totalPages) {
                            str += `<li class="page-item  disabled">
                    <a class="page-link" href="#${obj.page-1}">最後一頁</a>
                    </li>`
                        } else {
                            str += `<li class="page-item ">
                    <a class="page-link" href="#${obj.totalPages}">最後一頁</a>
                    </li>`
                        }


                        document.querySelector('.pagination').innerHTML = str;
                        // 把 str 塞到 class pagination裡

                    }

                );
        }
    </script>
<?php include __DIR__ . '../../parts/html_foot.php'; ?>