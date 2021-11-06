<?php

namespace frontend\models;

use yii\base\Model;

class OrderForm extends Model
{

    public $buyerEmail, $buyerPhone, $buyerName, $buyerAddress, $buyerNote, $check, $buyerProvinceId, $buyerDistrictId,$isVat,$method;

    public $isRecipient, $recipientName, $recipientEmail, $recipientPhone, $recipientAddress, $recipientProvinceId, $recipientDistrictId;
    public $companyName, $companyAddress, $vat, $paymentMethod, $o2opostman, $shipmentMethod, $promotionCode;
      
    public function rules()
    {
        return [
            [['buyerEmail', 'buyerName', 'buyerPhone', 'buyerAddress', 'buyerProvinceId', 'buyerDistrictId'], 'required'],
            [['buyerEmail'], 'email'],
            [['buyerName', 'paymentMethod'], 'string', 'max' => 50],
            [['buyerPhone'], 'string', 'max' => 20],
            [['buyerEmail'], 'string', 'max' => 150],
            [['buyerAddress', 'buyerNote', 'promotionCode'], 'string', 'max' => 250],
            [['companyName', 'companyAddress', 'vat'], 'string'],
            [['buyerPhone'], 'validatePhone'],
            [['buyerDistrictId', 'buyerProvinceId'], 'integer', 'min' => 1,  'tooSmall' => '{attribute} không được để trống'],
            [['isVat','method', 'shipmentMethod'], 'integer'],
            
            [['recipientName', 'recipientPhone', 'recipientEmail'], 'string', 'max' => 150],
            [['recipientAddress'], 'string', 'max' => 500],
            [['recipientProvinceId', 'recipientDistrictId', 'isRecipient', 'o2opostman'], 'integer'],
            [['recipientName', 'recipientPhone', 'recipientEmail', 'recipientAddress', 'recipientProvinceId', 'recipientDistrictId'], 'required', 'when' => function($model) {
                    return $model->isRecipient == 1;
                }]
        ];
    }

    public function validatePhone($attribute, $params){
        if(!preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i", $this->buyerPhone))
            $this->addError('buyerPhone', 'Số điện thoại không đúng định dạng');
    }

    public function attributeLabels()
    {
        return [
            'buyerEmail' => 'Email',
            'buyerPhone' => 'Số điện thoại',
            'buyerName' => 'Họ và tên',
            'buyerAddress' => 'Địa chỉ nhận hàng',
            'buyerNote' => 'Ghi chú',
            'buyerProvinceId' => 'Tỉnh thành',
            'buyerDistrictId' => 'Quận huyện',
            'isVat' => 'Nhận hóa đơn VAT',
            'method' => 'Phương thức vận chuyển',
            
            
            'recipientName' => 'Họ và tên người nhận',
            'recipientEmail' => 'Địa chỉ email',
            'recipientPhone' => 'Số điện thoại',
            'recipientAddress' => 'Địa chỉ nhận hàng',
            'recipientProvinceId' => 'Tỉnh thành',
            'recipientDistrictId' => 'Quận huyện',
        ];
    }

}
