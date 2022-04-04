<?php

class ScreenController extends Controller {

    public function actionIndex() {
        $screen_ids = Yii::app()->request->getParam('screen_ids');
        $this->render('index');
    }

    public function actionSave() {
        $result = array('status' => 'no');
        if (isset($_POST{'screen'})) {
            $screen_id = Yii::app()->request->getParam('screen_id');
            if ($screen_id != 0) {
                $screen = Screen::model()->findByPk($screen_id);
            } else {
                $screen = new Screen();
            }
            $screen->attributes = $_POST['screen'];
            $screen->user_id = 1;
            if ($screen_id) {
                $screen->update_time = $_SERVER["REQUEST_TIME"];
            } else {
                $screen->create_time = $_SERVER["REQUEST_TIME"];
                $screen->update_time = 0;
            }
            if ($screen->validate()) {
                if ($screen->save()) {
                    $result = array('status' => 'ok');
                }
            }
        }
        echo json_encode($result);
    }

    public function actionList() {
        $result = array();
        $criteria = new CDbCriteria;
        $criteria->alias = "screen";
        $criteria->compare('publish', 1);
        $criteria->compare('is_deleted', 0);
        $criteria->order  = 'screen.name ASC';
        $screen = Screen::model()->with(array('customer'))->findAll($criteria);
        $userId = Yii::app()->user->id;
        $userScreens = $screens = Screen::model()->getUserScreens($userId);
        $userActiveScreens = [];

        foreach ($userScreens as $data) {
            if ($data['is_on'] == 1) {
                array_push($userActiveScreens, $data['screen_id']);
            }
        }
       
        if (!empty($screen)) {
            foreach ($screen as $val) {
                if (in_array($val['screen_id'], $userActiveScreens)) {
                    $open = FALSE;
                    $screen_ids = Yii::app()->memcache->get('screen_1');
                    if ($screen_ids) {
                        $screen_id = explode(',', $screen_ids);
                        if (in_array($val['screen_id'], $screen_id)) {
                            $open = TRUE;
                        }
                    }
                    $result[] = array(
                        'screen_id' => $val['screen_id'],
                        'name' => $val['name'],
                        'customer' => $val['customer']['name'],
                        'customer_id' => $val['customer']['id'],
                        'width' => (int) $val['width'],
                        'height' => (int) $val['height'],
                        'ratio' => $val['ratio'],
                        'secret' => $val['secret'],
                        'is_open' => $open,
                        'spots'=> SpotsPos::model()->getPlaylistByScreenId($val['screen_id']),
                    );
                } 
            }
            Yii::app()->memcache->delete('screen_1');
        }
        echo json_encode($result);
    }

    public function actionDelete() {
        $result = array('status' => 'no');
        $screen_id = Yii::app()->request->getParam('screen_id', NULL);
        if (!empty($screen_id)) {
            $screen = Screen::model()->findByPk($screen_id);
            $screen->is_deleted = 1;
            if ($screen->update()) {
                $result = array('status' => 'ok');
            } else {
                $result = array('status' => 'no');
            }
        }
        echo json_encode($result);
    }
    
    public function actionPreview() {
        $screen = Yii::app()->request->getParam('screen_id');
        $spots = array();
        if($screen){
            $spots = SpotsPos::model()->getPlaylistByScreenId($screen);
        }
        echo json_encode($spots);
    }
}
