<?php
if(! isset($page_name)) $page_name='';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= $page_name=='vendor-list.php' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= WEB_ROOT ?>./vendor/vendor-list.php">修改廠商列表</a>
                </li>
                <li class="nav-item <?= $page_name=='vendor-insert2' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= WEB_ROOT ?>./vendor/vendor-insert2.php">新增</a>
                </li>

            </ul>
            <ul class="navbar-nav ">
                <?php if(isset($_SESSION['william'])): ?>
                    <li class="nav-item">
                        <a class="nav-link"><?= $_SESSION['william']['nickname'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= WEB_ROOT ?>./logout.php">登出</a>
                    </li>

                <?php else: ?>
                    <li class="nav-item <?= $page_name=='login' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= WEB_ROOT ?>./login.php">登入</a>
                    </li>
                <?php endif; ?>
            </ul>
        </form>
    </div>
    </div>
</nav>
<style>
    .navbar .nav-item.active{
    background-color: #7abaff;
        border-radius: 10px;
    }
</style>
