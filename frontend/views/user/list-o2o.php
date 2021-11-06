<?php
use common\components\ImageClient;
use frontend\widgets\UserSidebar;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\grid\Column;

?>
<div class="container container-v2" ng-controller="list-o2o" ng-cloak>
  <div class="l-content">
    <ol class="breadcrumb">
      <li><a href="#">Trang chủ</a></li>
      <li class="active">Danh sách chiến dịch bán hàng liên kết</li>
    </ol>
    <div class="clearfix">
      <div class="l-main is-normal">
        <div class="c-whitebox">
          <div class="c-whitebox__title">
            <div class="c-whitebox__title__name">Danh sách chiến dịch bán hàng liên kết</div>
          </div>
          <div class="c-whitebox__content">
            <div class="c-whitebox__inner">
              <div class="table-responsive c-table-bill">
                    <?php
                    echo GridView::widget([
                        'dataProvider' => $data,
                        'tableOptions' => [
                            'class' => 'table card-table table-vcenter text-nowrap'
                        ],
                        'layout' => '<div class="table-responsive">{items}</div><div class="card-footer">{summary}{pager}</div>',
                        'pager' => [
                            'options' => ['class' => 'pagination pagination-sm justify-content-end']
                        ],
                        'columns' => [
                            [
                                'class' => DataColumn::className(),
                                'attribute' => 'id',
                            ],
                            [
                                'class' => DataColumn::className(),
                                'attribute' => 'name',
                                'label' => 'Link chiến dịch',
                                'content' => function ($model) {
                                    $content = '<a href="' . $model->createUrl() . '" id="' . $model->id . '">';
                                    $content .= $model->name;
                                    $content .= '</a>';
                                    return $content;
                                }
                            ],
                            [
                                'class' => DataColumn::className(),
                                'attribute' => 'name',
                                'label' => 'Copy link chiến dịch',
                                'content' => function ($model) {
                                    $content = "<button onclick='copyToClipboard($model->id)' id='id$model->id' >";
                                    $content .= "Copy link";
                                    $content .= "</button>";
                                    return $content;
                                }
                            ],
                            [
                                'class' => DataColumn::className(),
                                'label' => 'Mã chiến dịch',
                                'attribute' => 'code',
                            ],
                            [
                                'class' => DataColumn::className(),
                                'attribute' => 'realtime',
                                'label' => 'Ngày tạo',
                                'content' => function($m) {
                                    return $m->realtime != '' ? date('d-m-Y', $m->realtime) : 'Không có';
                                }
                            ],
                            [
                                'class' => DataColumn::className(),
                                'attribute' => 'productIds',
                            ],
                        ],
                    ])
                    ?>
              </div><!-- table-responsive -->
            </div><!-- c-whitebox__inner -->
          </div><!-- c-whitebox__content -->
        </div><!-- c-whitebox -->
      </div><!-- l-main --> 
      <?php echo UserSidebar::widget(); ?>
    </div><!-- clearfix -->
  </div><!-- l-content -->
</div><!-- container -->