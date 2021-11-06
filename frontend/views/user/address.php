<?php
use yii\helpers\Url;
use common\models\ProductSearch;
use common\models\Keyword;
use common\components\ImageClient;
use frontend\widgets\UserSidebar;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

?>
<div class="content content-user">
    <div class="container">

      
      <div class="br-content">
        <ol class="breadcrumb">
          <li><a href="<?= Url::home() ?>">Trang chủ</a></li>
        <li class="active">Trang cá nhân</li>
    </ol>
      </div>
        <div class="main-content-right main-content-user main-content-history">
          <div class="box-infomation box-bill-history">
                <h3>Danh sách địa chỉ nhận hàng:</h3>
                <div class="table-responsive ">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 10%">Địa chỉ</th>
                        <th class="text-center" style="width: 15%">Quận huyện</th>
                        <th class="text-center" style="width: 15%">Tỉnh thành</th>
                        <th class="text-center" style="width: 18%">Mặc định khi đặt hàng</th>
                      </tr>
                    </thead>
                    <tbody>
                     <tr>
                         <td colspan="4" align="right"><button>Thêm</button></td>
                     </tr>
                    </tbody>
                  </table>
                </div>               
            </div><!-- end .box-infomation-->
        </div>
        <?php echo UserSidebar::widget(); ?>
        <div class="clearfix"></div>
    </div>
</div>
