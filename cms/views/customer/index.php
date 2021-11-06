<?php

use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\grid\Column;
use yii\helpers\Url;
use yii\helpers\Html;
use cms\widgets\Messages;
use common\models\Gamelienminh;

?>
<section class="content-header">
	<h1><?= Html::encode($this->title) ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?= Url::home() ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<?php echo Messages::widget(); ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="box">
				<div class="box-header with-border">
					<!-- <h3 class="box-title">Danh sách quản trị viên</h3> -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
						<?php

						echo GridView::widget([
							 'dataProvider' => $data,
							'tableOptions' => [
								'class' => 'table table-condensed'
							],
							'layout' => '{items}<div class="box-footer clearfix">{summary}{pager}</div>',
							'pager' => [
								'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
							],
							'summaryOptions' => [
								'class' => 'no-margin pull-left'
							],
							'columns' => [
								[
									'class' => DataColumn::className(),
									'attribute' => 'id',
								],
								[
									'class' => DataColumn::className(),
									'attribute' => 'name'
								],
								[
									'class' => DataColumn::className(),
									'attribute' => 'phone'
								],
								[
									'class' => DataColumn::className(),
									'attribute' => 'email'
								],
								[
									'class' => DataColumn::className(),
									'attribute' => 'Trạng thái',
									'content' => function($model){
										$html = '<span class="label label-danger">Chặn</span>';
										if($model->status == 1){
											$html = '<span class="label label-success">Hoạt động</span>';
										}
										return $html;
									}
								],
								[
									'class' => Column::className(),
									'content' => function ($model) {
										$html = '';
										$html .= '<div class="btn-group btn-group-xs">'
										. '<a href="' . Url::to(['form', 'id' => (string)$model->id]) . '" class="btn btn-primary"><i class="fa fa-edit"></i> Sửa</a>'
										. '<a data-confirm="Bạn có chắc chắn muốn xóa không?!" href="' . Url::to(['delete', 'id' => (string)$model->id]) . '" class="btn btn-danger"><i class="fa fa-remove"></i> Xóa</a>'
										. '</div>';
										return $html;
									},
									'contentOptions' => ['class' => 'text-center'],
									'header' => '<a href="' . Url::to(['form']) . '" class="btn btn-xs btn-success">Thêm mới</a>',
									'headerOptions' => ['class' => 'text-center', 'style' => 'width: 200px'],
								],
							],
						])
						?>
					</div> <!-- /.table-responsive -->
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col-lg-12 -->
	</div>  <!-- /.row -->
</section>