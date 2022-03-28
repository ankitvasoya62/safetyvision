<?php
class EmailTool extends CComponent
{
    /**
     ***************************************************************************
     * 
     *  Author : <lih@shinetechchina.com>
     *  eg.('ov@info.no,ov2@info.no','phpmailer','Hello,Email')
     *  eg.('ov2@info.no','phpmailer','Hello,Email')
     *  @receiver one or more
     *  @subject Email Subject
     *  @html Email Content
     *  @return boolean
     * 
     ***************************************************************************
     **/
     public static function sendEmail($receiver='', $subject='', $html='')
     {
             Yii::import('application.extensions.phpmailer.*');
             require_once("class.phpmailer.php");
             $smtpInfo         = Yii::app()->params->smtp;
             $mail             = new PHPMailer();
             $mail->Host       = $smtpInfo['server'];
             $mail->Username   = $smtpInfo['user'];
             $mail->Password   = $smtpInfo['password'];

             $mail->IsSMTP();
             $mail->IsHTML();
             $mail->CharSet    = 'UTF-8';
             $mail->SMTPAuth   = true;
             $mail->SMTPSecure = 'ssl';
             $mail->Port       = 465;
             $mail->SMTPDebug  = FALSE;

             $mail->SetFrom($smtpInfo['user'],'SafetyVision');
             $mail->Subject    = $subject;
             $mail->MsgHTML($html);
             
             if(strpos($receiver, ',')){
                 $receivers = explode(',', $receiver);
                 foreach ($receivers as $value) {
                      $mail->AddAddress($value);
                 }
             }else{
                 $mail->AddAddress($receiver);
             }
             if(!$mail->Send()) {
                    return false;
             } else {
                    return true;
             }
    }
}
