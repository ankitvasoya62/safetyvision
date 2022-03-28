<?php

class ApiController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionGetPlaylist() {
        $screen_id = Yii::app()->request->getParam('screen_id');
        if ($screen_id) {
            $screen = Screen::model()->find("id = {$screen_id} AND is_deleted = 0");
            $screenInfo = array();
            if ($screen) {
                $screenInfo = $screen->attributes;
            }
            $spotInfo = array();
            $spots = SpotsPos::model()->getPlaylistByScreenId($screen_id,"DESC");
            if ($spots) {
                $spotInfo = $spots;
            }
            echo json_encode(array('screen' => $screenInfo, 'spots' => $spotInfo));
        } else {
            echo json_encode(array('screen' => array(), 'spots' => array()));
        }
    }

}