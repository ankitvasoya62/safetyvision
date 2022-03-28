<?php

class SvController extends Controller {

    public function actionIndex() {
        $data = json_encode(array('cmd' => 'stop'));
        $socket = new Socket();
        $socket->bind();
        $socket->listen();
        $socket->accept();
        $socket->connect();
        $socket->write($data);
        $socket->close();
    }

    public function actionTest() {
        //http://ahui.visionsafety.com/screen/preview/spot/spot_id/5.html

        $lihui = '8pk4KfvACfODBrWmXQ';

        echo Helpers::encrypt($lihui, 'D', 123456);
    }

    public function actionPhp() {
        phpinfo();
    }

    public function actionInit() {
        UserOperate::model()->initTable();
    }
    
    public function actionAccess(){
        echo '<pre>';
        print_r(User::model()->getAccess(4));
        exit();
    }
    

}
