<?php

$page_title='資料列表';

require __DIR__.'../../parts/connect_db.php';
$perPage = 5;

$page = isset($_GET['page'])? intval($_GET['page']) : 1;


$t_sql = "SELECT COUNT(1) FROM `vendor-list`";
$totalRows =  $pdo ->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
//die('!!!!!!!!!!');

$totalPages = ceil($totalRows/$perPage);

$rows=[];
if($totalRows>0){
    if($page<1)$page=1;
    if($page>$totalPages)$page = $totalPages;


    $sql = sprintf("SELECT * FROM `vendor-list` ORDERBY LIMIT %s, %s", ($page-1)*$perPage, $perPage);

    $stmt = $pdo->query($sql);


    $rows = $stmt ->fetchAll();
}

?>
<?php include  __DIR__.'/parts/html_head.php';?>
<?php include  __DIR__.'/parts/navbar.php';?>






<div class="container">
    <div class="row">
        <div class="col d-flex justify-content-end">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <!--                    <li class="page-item ">-->
                    <!--                        <a class="page-link" href="?page=">-->
                    <!--                            <i class="fas fa-arrow-circle-left"></i>-->
                    <!--                        </a>-->
                    <!--                    </li>-->

                    <!--                    <li class="page-item ">-->
                    <!--                        <a class="page-link" href="?page="></a>-->
                    <!--                    </li>-->

                    <!--                    <li class="page-item ">-->
                    <!--                        <a class="page-link" href="?page=">-->
                    <!--                            <i class="fas fa-arrow-circle-right"></i>-->
                    <!--                        </a>-->
                    <!--                    </li>-->
                </ul>
            </nav>

        </div>
    </div>


    <table class="table table-striped">
        <!-- `sid`, `name`, `email`, `mobile`, `birthday`, `address`, `created_at` -->
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">廠商名稱</th>
            <th scope="col">地址</th>
            <th scope="col">信箱</th>
            <th scope="col">統一編號</th>
            <th scope="col">聯絡人</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>
<?php include __DIR__. '/parts/script.php'; ?>
<script>
    const tboday = document.querySelector('tbody');

    let pageData;

    const hashHandler = function(event){
        let h = parseInt(location.hash.slice(1)) || 1;
        if(h<1) h = 1;
        console.log(`h: ${h}`);
        getData(h);
    };
    window.addEventListener('hashchange', hashHandler);
    hashHandler(); // 頁面一進來就直接呼叫

    const pageItemTpl = (o)=>{

        return `<li class="page-item ${o.active}">
                        <a class="page-link" href="#${o.page}">${o.page}</a>
                </li>`;
    };

    const tableRowTpl = (o)=>{

        return `
        <tr>
                <td>${obj.sid}</td>
                <td>${obj.vendor_name}</td>
                <td>${obj.address}</td>
                <td>${obj.TEL}</td>
                <td>${obj.email}</td>
                <td>${obj.tax_ID_number}</td>
                <td>${obj.contact_person}</td>
        </tr>
        `;
    };


    function getData(page=1) {
        fetch('vendor-list2-api.php?page='+ page)
            .then(r => r.json())
            .then(obj => {
                console.log(obj);
                pageData = obj;
                let str = '';
                for (let i of obj.rows) {
                    str += tableRowTpl(i);
                }
                tboday.innerHTML = str;

                str = '';
                for (let i = obj.page - 3; i <= obj.page + 3; i++) {
                    if (i < 1) continue;
                    if (i > obj.totalPages) continue;
                    const o = {page: i, active: ''}
                    if (obj.page === i) {
                        o.active = 'active';
                    }
                    str += pageItemTpl(o);
                }
                document.querySelector('.pagination').innerHTML = str;
            });
    }

</script>
<?php include  __DIR__.'/parts/html_foot.php';?>

