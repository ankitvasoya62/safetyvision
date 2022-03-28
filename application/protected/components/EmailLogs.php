<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EmailLogs extends CEmailLogRoute {

    protected function processLogs($logs) {
        $message = '';
        foreach ($logs as $log)
            $message.=$this->formatLogMessage($log[0], $log[1], $log[2], $log[3]);
        $message = wordwrap(str_replace("#", "<br>#", $message), 200);
        $subject = $this->getSubject();
        if ($subject === null)
            $subject = Yii::t('yii', 'SafetyVision Error Logs:');
        foreach ($this->getEmails() as $email){
            EmailTool::sendEmail($email, $subject, $message);
        }
            $this->sendEmail($email, $subject, $message);
    }
}
