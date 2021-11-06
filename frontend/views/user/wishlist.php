<?php
use common\components\ImageClient;
use frontend\widgets\UserSidebar;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\grid\Column;

?>
<div class="container container-v2" ng-controller="historyOrder">
  <div class="l-content">
    <ol class="breadcrumb">
      <li><a href="#">Trang chủ</a></li>
      <li class="active">Sản phẩm yêu thích</li>
    </ol>
    <div class="clearfix">
      <div class="l-main is-normal">
        <div class="c-whitebox">
          <div class="c-whitebox__title">
            <div class="c-whitebox__title__name">Sản phẩm yêu thích</div>
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
                                'attribute' => 'productCode',
                            ],
                            [
                                'class' => DataColumn::className(),
                                'attribute' => 'name',
                                'content' => function ($model) {
                                    $content = '<a href="' . $model->createUrl() . '">';
                                    $content .= $model->name;
                                    $content .= '</a>';
                                    return $content;
                                }
                            ],
                            [
                                'class' => DataColumn::className(),
                                'attribute' => 'price',
                                'content' => function ($model) {
                                    return number_format($model->price);
                                }
                            ],
                            [
                                'class' => DataColumn::className(),
                                'attribute' => 'merchantId',
                                'content' => function ($model) {
                                    return $model->merchant->name;
                                }
                            ],
                            [
                                'class' => DataColumn::className(),
                                'attribute' => 'image',
                                'content' => function ($model) {
                                    if ($model->image) {
                                        return '<img style="max-width: 75px;" src="' . common\components\ImageClient::thumb($model->image, 75) . '" />';
                                    } else {
                                        return 'Không có';
                                    }
                                }
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