<?php

class PreviewController extends Controller {

    public function actionSpot() {
        $spot_id = Yii::app()->request->getParam('pBuOZzuzDSAIGx8', NULL);
        if ($spot_id) {
            $spot_id = base64_decode($spot_id);
            $spot = Spots::model()->findByPk($spot_id);
            if ($spot) {
                $res = json_decode($spot->resource, true);
                $this->renderPartial('spot', array('spot' => $spot, 'res' => $res));
            } else {
                Yii::app()->end();
            }
        } else {
            Yii::app()->end();
        }
    }

    public function actionWindow() {
        $screen_id = Yii::app()->request->getParam('screen_id');
        $result = array("width" => 1000, "height" => 563, "name" => "", "screen_id" => $screen_id,'url'=>'/screen/preview/fullDemo/screen_id/');
        if ($screen_id) {
            $screen = Screen::model()->findByPk($screen_id);
            if ($screen) {
                $result['name'] = $screen->name;
                if ($screen->ratio) {
                    $ratio = explode(":", $screen->ratio);
                    $result['height'] = round(($ratio[1] * $screen->window_width ) / $ratio[0]);
                }
                $result['url'] = $result['url'].$screen_id.'.html';
            }
        }
        echo json_encode(array('screen' => $result));
    }

    public function actionFullDemo() {
        $result = array();
        $screen_id = Yii::app()->request->getParam('screen_id');
        if ($screen_id) {
            $screen = Screen::model()->findByPk($screen_id);
            $spots = SpotsPos::model()->getPlaylistByScreenId($screen_id);
            
            if(!empty($spots)){
                foreach ($spots as $val) 
                {
                    $status = VSCommon::checkSpotStatus($val['start_date'], $val['stop_date'], $val['start_hh'], $val['stop_hh']);
                    if($val['pc'] == 'y' && $status != 0){
                        array_push($result, $val);
                    }
                }
            }
            
           $this->renderPartial('fulldemo', array('screen'=>$screen, 'spots' => $result));
        } else {
            Yii::app()->end();
        }
    }

}
