<?php

namespace common\models;

use common\components\TextUtils;
use common\components\ProductDiscount;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "product".
 */
class Product extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'price', 'keywords','description', 'image', 'categoryId', 'vat'], 'required'],
            [['name'], 'unique'],
            [['image','thumbnail', 'keywords','description','description2', 'categories'], 'string'],
            [['price', 'promotion', 'createTime', 'status', 'rating', 'view', 'position'], 'integer'],
            [['name', 'image'], 'string', 'max' => 250],
            [['categoryId',], 'integer', 'min' => 1, 'tooSmall' => '{attribute} chưa được chọn'],
            [['vat'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'status' => 'Trạng thái',
            'categoryId' => 'Danh mục',
            'merchantId' => 'Nhà cung cấp',
            'warehouseId' => 'Kho',
            'areaId' => 'Khu vực',
            'provinceId' => 'Tỉnh thành',
            'districtId' => 'Quận huyện',
            'countryId' => 'Quốc gia',
            'brandId' => 'Thương hiệu',
            'name' => 'Tên',
            'image' => 'Ảnh đại diện',
            'thumbnail' => 'Ảnh đại diện',
            'images' => 'Ảnh',
            'description' => 'Mô tả ngắn',
            'description2' => 'Mô tả chi tiết',
            'keywords' => 'Từ khóa',
            'weight' => 'Khối lượng',
            'length' => 'Dài',
            'shippingWeightMultiple' => 'Hệ số chênh lệch khối lượng vận chuyển',
            'width' => 'Rộng',
            'height' => 'Cao',
            'reject' => 'Từ chối',
            'approved' => 'Approved',
            'activated' => 'Trạng thái',
            'available' => 'Available',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
            'upTime' => 'Up Time',
            'listPrice' => 'Giá niêm yết',
            'price' => 'Giá bán',
            'commissionPercent' => 'Commission Percent',
            'commissionAmount' => 'Commission Amount',
            'viewCount' => 'View Count',
            'buyCount' => 'Buy Count',
            'likeCount' => 'Like Count',
            'deliveryLimitation' => 'Giới hạn phương thức vận chuyển',
            'status_retouch' => 'KQTĐ retouch',
            'status_content' => 'KQTĐ nội dung',
            'unit' => 'Đơn vị tính',
            'ohio'  => 'O2o',
            'percent' => 'Phần trăm',
            'commissionType' => 'Kiểu hoa hồng',
            'commissionValue' => 'Giá trị',
            'allowAffiliate' => 'Bật bán hàng liên kết',
            'position' => 'Vị trí',
            'vat' => 'Thuế VAT',
        ];
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'categoryId']);
    }

     public function getRatings() {
        return $this->hasMany(Rating::className(), ['productId' => 'id']);
    }

    public function createUrl() {
        return Url::to(['product/detail', 'id' => $this->id, 'name' => TextUtils::createAlias($this->name)]);
    }
}
