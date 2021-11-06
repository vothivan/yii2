<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use cms\widgets\Messages;
use yii\helpers\Url;
?>

<section class="content-header">
    <h1>
        Báo cáo
        <small>Thống kê đơn hàng</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= Url::home() ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">Thống kê đơn hàng</li>
    </ol>
</section>
<!-- Main content -->
<section class="content" ng-controller="report_order" ng-cloak>
    <?php echo Messages::widget(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="nav-tabs-custom">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Tìm kiếm</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-sm-4">
                                <form method="GET" action="">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label style="width: 90px">Từ ngày:</label>
                                            <input name="startDate" value="<?= $startDate ?>" type="text" class="form-control input-sm"
                                                uib-datepicker-popup ng-model="startDate" is-open="popup1.opened"
                                                datepicker-options="dateOptions" close-text="Close"/>
                                            <button type="button" class="btn btn-default" ng-click="open1()">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label style="width: 90px">Đến ngày:</label>
                                            <input name="endDate" value="<?= $endDate ?>"  type="text" class="form-control input-sm"
                                                uib-datepicker-popup ng-model="endDate" is-open="popup2.opened"
                                                datepicker-options="dateOptions" close-text="Close"/>
                                            <button type="button" class="btn btn-default" ng-click="open2()">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </button>
                                        </div>
                                    </div>
           
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label style="width: 90px">Trạng thái: </label>
                                            <select name="status" class="form-control"
                                                    style="width: 145px">
                                                <option value="-1">Tất cả</option>
                                                <option <?= $status == 0 ? 'selected="selected:' : '' ?> value="0">Chờ duyệt</option>
                                                <option <?= $status == 1 ? 'selected="selected:' : '' ?> value="1">Đã duyệt</option>
                                                <option <?= $status == 2 ? 'selected="selected:' : '' ?> value="2">Đang giao hàng</option>
                                                <option <?= $status == 3 ? 'selected="selected:' : '' ?> value="3">Đã giao hàng</option>
                                                <option <?= $status == 4 ? 'selected="selected:' : '' ?> value="4">Huỷ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <input type="submit" class="btn btn-default" value="Tìm kiếm"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs">
                    <li class="">
                        <?=
                        ExportMenu::widget([
                            'dataProvider' => $provider,
                            'fontAwesome' => false,
                            'columns' => $columns,
                            'options' => ['id' => 'export_button'],
                            'target' => ExportMenu::TARGET_SELF,
                            'dropdownOptions' => [
                                'label' => 'Xuất dữ liệu',
                            ],
                            'exportConfig' => [
                                ExportMenu::FORMAT_HTML => false,
                                ExportMenu::FORMAT_CSV => false,
                                ExportMenu::FORMAT_TEXT => false,
                                ExportMenu::FORMAT_EXCEL => false,
                            ],
                            'showConfirmAlert' => false,
                            'showPageSummary' => true,
    //                                    'batchSize' => 1,
                            "contentBefore" => $heading,
                        ]);
                        ?>                  
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="path">
                    
                        <?=
                        GridView::widget([
                            'dataProvider' => $provider,
                            'columns' => $columns,
                            'showPageSummary' => true,
                        ]);
                        ?>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</section>
<script>
    var merchantId = 0;
    var status = <?= $status ?>;
    var endDate = '<?= $endDate ?>';
    var startDate = '<?= $startDate ?>';
</script>