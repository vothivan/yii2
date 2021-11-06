<?php

namespace cms\controllers;

use cms\components\Controller;
use common\models\Product;
use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\OrderProduct;
use common\models\Order;


class ReportController extends Controller
{

    public function behaviors(){
        $this->checkAuth();
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($startDate = 0, $endDate = 0, $status = -1){
       $startTime = 0;
        $endTime = 0;
        if($startDate == 0) 
            $startDate = date('Y-m-d', strtotime('-1 year'));
        $startTime = strtotime($startDate);
        if($endDate == 0) 
            $endDate = date('Y-m-d');
        $endTime = strtotime($endDate);
        $beginOfDay = strtotime("midnight", $endTime);
        $endTime   = strtotime("tomorrow", $beginOfDay) - 1;

        $this->view->title = 'Báo cáo đơn hàng';

        $query = Order::find()
        ->with(['products', 'customer'])
        ->andWhere(['>=', Order::tableName() . '.createTime', $startTime])
        ->andWhere(['<=', Order::tableName() . '.createTime', $endTime])
        ->orderBy(Order::tableName() . '.id DESC');


        if($status != -1){
            $query->andWhere(['status' => $status]);
        }

        $totalAmount = (clone $query)->sum("totalPrice");

        $heading[] = ["value" => "Tổng số tiền: " . $totalAmount];
        
        $columns = [
            
            [   
                'label' => 'Thời gian đặt hàng',
                'value' => function($data) {
                    return date('d/m/Y h:i:s', $data->createTime);
                }
            ],
            [
                'attribute' => 'id',
                'label' => 'Mã đơn hàng',
                'vAlign' => 'middle',
            ],
            [
                'attribute' => 'contactName',
                'label' => 'Tên người nhận',
                'vAlign' => 'middle',
            ],
            [
                'attribute' => 'contactPhone',
                'label' => 'Số điện thoại',
                'vAlign' => 'middle',
                'value' => function($data) {
                    return $data->contactPhone.'';
                }
            ],
            [
                'attribute' => 'contactEmail',
                'label' => 'Email người nhận',
                'vAlign' => 'middle',
            ],
            [
                'attribute' => 'address',
                'label' => 'Địa chỉ người nhận',
                'vAlign' => 'middle',
            ],
            [
                'attribute' => 'totalPrice',
                'label' => 'Tiền hàng',
                'vAlign' => 'middle',
            ],
            // [
            //     'attribute' => 'status',
            //     'label' => 'Tên người nhận',
            //     'vAlign' => 'middle',
            // ],
            [
                'attribute' => 'confirmTime',
                'label' => 'Thời gian duyệt đơn',
                'vAlign' => 'middle',
                'value' => function($data) {
                    if(intval($data->confirmTime) == 0){
                        return '';
                    }
                    return date('d/m/Y h:i:s', $data->confirmTime);
                }
            ],
            [
                'attribute' => 'doneTime',
                'label' => 'Thời gian hoàn thành',
                'vAlign' => 'middle',
                'value' => function($data) {
                    if(intval($data->doneTime) == 0){
                        return '';
                    }
                    return date('d/m/Y h:i:s', $data->doneTime);
                }
            ],
            [
                'attribute' => 'cancelTime',
                'label' => 'Thời gian hủy',
                'vAlign' => 'middle',
                'value' => function($data) {
                    if(intval($data->cancelTime) == 0){
                        return '';
                    }
                    return date('d/m/Y h:i:s', $data->cancelTime);
                }
            ],
            
          
        ];

        return $this->render('index', [
            'provider' => new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]),
            'columns' => $columns,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'heading' => $heading,
            'status' => $status,
            "totalAmount" => $totalAmount
        ]);
    }

}
