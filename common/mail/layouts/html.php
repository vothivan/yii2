<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\InfoConfig;
$info = InfoConfig::findOne(1);

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<style type="text/css" media="screen">
    .status-default {
        background: #ed1c24;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        font-size: 12px;
    }
    .status-cancel {
        background: #0054a6;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        font-size: 12px;
    }
    .status-payment {
        background: #9ac430;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        font-size: 12px;
    }
    .status-yellow {
        background: #ffbe38;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        font-size: 12px;
    }
    .status-order {
        background: #29bbff;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        font-size: 12px;
    }
    .status-purple {
        background: #9939e3;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        font-size: 12px;
    }
    .status-oregane {
        background: #f26522;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        font-size: 12px;
    }
    .status-tracking {
        background: #0773ef;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        font-size: 12px;
    }
</style>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background: #ededed; font-size: 14px;">
<table border="0" width="700" align="center" cellpadding="0" cellspacing="0" style="background: #ededed;">
    <tr>
        <td style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:5px;padding-bottom:5px;padding-right:0;padding-left:0;text-align:left;" >
        </td>
    </tr>
</table>
<table border="0" width="700" align="center" cellpadding="0" cellspacing="0" style="background: #fff; padding:15px;">
    <tr>
        <td width="50%" style="padding-bottom: 10px;">
            <a href="#" target="_blank"><img src="http://voso.vn/static/images/logo-footer.png" alt="" title="" style="width: 320px;" /></a>
        </td>
        <td width="50%" style="text-align: right; padding-bottom: 10px;">
            <a href="#" target="_blank" style="text-decoration: none;color: #333"><img src="http://voso.vn/static/images/icon-phone.png" alt="" title="" style="vertical-align: middle;margin-right: 5px;" /><?=$info->contactPhone ?></a>
            <a href="#" target="_blank" style="text-decoration: none;color: #333;margin-left: 20px;"><img src="http://voso.vn/static/images/icon-mail.png" alt="" title=""style="vertical-align: middle;margin-right: 5px;"/><?=$info->contactEmail ?></a>
        </td>
    </tr>
    <?= $content ?>
    <tr>
        <td colspan="2" style="padding-bottom: 5px;">Voso.vn trân trọng cảm ơn và rất hân hạnh được phục vụ Quý khách.</td>
    </tr>
    <tr>
        <td colspan="2" style="padding-bottom: 5px;">Mọi thắc mắc và góp ý, xin Quý khách vui lòng liên hệ với chúng tôi qua:</td>
    </tr>
    <tr>
        <td colspan="2" style="padding-bottom: 5px;">Email hỗ trợ: <?=$info->contactEmail ?>  hoặc  Tổng đài tư vấn: <strong><?=$info->contactPhone ?></strong> </td>
    </tr>
    <tr>
        <td colspan="2" style="background:#ececec;border-top:2px solid #3c9444;padding-top:10px;text-align:center;">
            <a href="http://tintuc.voso.vn/chinh-sach-thanh-toan" style="color: #333;text-decoration: none;display: inline-block;padding: 0 5px;">Phương thức thanh toán</a> |
            <a href="http://tintuc.voso.vn/chinh-sach-giao-nhan-hang" style="color: #333;text-decoration: none;display: inline-block;padding: 0 5px;">Giao hàng</a> |
            <a href="http://tintuc.voso.vn/trung-tam-ho-tro-khach-hang" style="color: #333;text-decoration: none;display: inline-block;padding: 0 5px;">Hỗ trợ khách hàng</a> |
            <a href="http://tintuc.voso.vn/cau-hoi-thuong-gap/don-hang-2.html" style="color: #333;text-decoration: none;display: inline-block;padding: 0 5px;">Hướng dẫn mua hàng</a> |
            <a href="http://tintuc.voso.vn/lien-he" style="color: #333;text-decoration: none;display: inline-block;padding: 0 5px;">Liên hệ</a>
            <p style="text-align:center;">Bản quyền © 2019. Voso.vn </p>
        </td>
    </tr>
    <tr>
        <td style="height:10px;"></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center;font-style: italic;font-size: 12px;">Đây là mail tự động, Quý khách vui lòng không trả lời .</td>
    </tr>
</table>
</body>

</html>
