<?php
/**
 * Created by PhpStorm.
 * User: phugt
 * Date: 3/15/2016
 * Time: 2:02 PM
 */

namespace common\components;


use common\models\MailLog;
use common\models\MailQueueResend;
use common\models\SmsLog;
use OAuth\Common\Exception\Exception;
use Yii;

class SMailClient
{

    public static function sendSMail($view, $data, $email, $subject)
    {
        try {
            Yii::$app->mailer->compose($view, $data)->setFrom([Yii::$app->params['mailSender'] => Yii::$app->params['mailSenderName']])
                ->setTo($email)
                ->setSubject($subject)
                ->send();
            self::writeLog($email, $subject, 'Gửi mail thành công');
            // return $rs[0];
            // object(stdClass){
            //   ["return"]=>
            //   string(10) "00|Success"
            // }
        } catch (\Exception $t) {
            $mailRs = new MailQueueResend();
            $mailRs->email = $email;
            $mailRs->titleEmail = $subject;
            $mailRs->data = $data;
            $mailRs->template = $view;
            $mailRs->save();
            self::writeLog($email, $subject, 'Có lỗi khi gửi mail', $t);
        }
    }

    public static function send($view, $data, $email, $subject, $flag = true)
    {
        try {
            $params = [
                'view' => $view,
                'data' => $data,
                'email' => $email,
                'subject' => $subject,
            ];
            $rb = new Rbmq();
            $rb->pub($params, 'voso_mail');
            self::writeLog($email, $subject, 'Đã gửi mail lên queue', $params);
        } catch (\Exception $t) {
            if ($flag) {
                $mailRs = new MailQueueResend();
                $mailRs->email = $email;
                $mailRs->titleEmail = $subject;
                $mailRs->data = json_encode($data,true);
                $mailRs->template = $view;
                $mailRs->countSent = 0;
                $mailRs->save(false);
            }
            self::writeLog($email, $subject, 'Có lỗi khi gửi mail lên queue', $t);
        }
    }

    private static function writeLog($email, $subject, $mes = '', $t = '')
    {
        $log = new MailLog();
        $log->receiver = $email;
        $log->content = $subject;
        $log->result = $mes;
        $log->log = json_encode($t);
        $log->time = time();
        $log->save(false);
    }
}
