<?php

use yii\helpers\Url;

?>

<footer class="main-footer">
    <strong>Gadget Developer</strong>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <div class="row" style="margin: 10px 10px">
        <a class="btn btn-info form-control" href="<?= Url::to(['site/changepassword']) ?>">Đổi mật khẩu</a>
    </div>
    <div class="row" style="margin: 10px 10px">
        <a class="btn btn-danger form-control" href="<?= Url::to(['site/logout']) ?>">Thoát</a>
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
