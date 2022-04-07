<?php

class SpotsPos extends CActiveRecord {
    
    public $status = 0;

    public function tableName() {
        return 'sv_spots_pos';
    }

    public function rules() {
        return array(
            array('spot_id, playlist_id, pos', 'numerical', 'integerOnly' => true),
            array('public, deleted', 'length', 'max' => 1),
            array('id, spot_id, playlist_id, pos, public, deleted', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {

        return array(
            'spot' => array(self::HAS_MANY, 'Spots', 'spot_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'spot_id' => 'Spot',
            'playlist_id' => 'Playlist',
            'pos' => 'Pos',
            'public' => 'Public',
            'deleted' => 'Deleted',
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('spot_id', $this->spot_id);
        $criteria->compare('playlist_id', $this->playlist_id);
        $criteria->compare('pos', $this->pos);
        $criteria->compare('public', $this->public, true);
        $criteria->compare('deleted', $this->deleted, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function addPlaylist($spot_id, $screen_ids) {
        if (is_string($screen_ids)) {
            $screen_ids = explode(',', $screen_ids);
        }
        $insertSQL = "INSERT INTO " . self::model()->tableName() . "(`spot_id`, `playlist_id`,`pos`,`public`,`deleted`) VALUES ";
        foreach ($screen_ids as $val) {
            $pos = $this->checkPosOrder($val);
            $insertSQL .= "( {$spot_id}, {$val}, {$pos},'n','n' ),";
        }
        $insertSQL = rtrim($insertSQL, ',') . ';';
        Yii::app()->db->createCommand($insertSQL)->execute();
    }

    private function checkPosOrder($screen_id) {
        $spotPos = self::model()->findAll("playlist_id = {$screen_id} AND public = 'n' AND deleted = 'n'");
        return count($spotPos) + 1;
    }

    public function getPlaylistByScreenId($screen_id, $order="ASC") {
        $screen = Screen::model()->findByPk($screen_id);
        if(!$screen->is_deleted){
            $SQL = "SELECT spot.*,spot.id sid,pos.*,pos.id pid,pos.public pc FROM sv_spots_pos AS pos LEFT JOIN sv_spots AS spot ON pos.spot_id = spot.id "
                    . "WHERE pos.playlist_id = {$screen_id} AND pos.deleted='n' ORDER BY pc ASC, pos.pos {$order}";
            $result = array();
            $spots = Yii::app()->db->createCommand($SQL)->queryAll();
            if ($spots) {
                foreach ($spots as $val) {
                    $resource = json_decode($val['resource'], true);
                    $val['image'] = $resource['image'];
                    $val['time_days'] = $val['start_hh'] . " - " .  $val['stop_hh'];
                    $val['cmd'] = $this->__getCmd($screen_id, $val['sid']);
                    $val['video'] = $resource['video'];
                    $val['filesize'] = $this->formatSizeUnits($val['filesize']);
                    $status = VSCommon::checkSpotStatus($val['start_date'], $val['stop_date'], $val['start_hh'], $val['stop_hh']);
                    if($val['pc'] == 'y'){
                        if($status == 2){
                            $val['status'] = 2;
                        }elseif($status == 1){
                            $val['status'] = 1;
                        }else{
                           $val['status'] = 3;
                        }
                    }else{
                        if($status == 2){
                            $val['status'] = -2;
                        }elseif($status == 1){
                            $val['status'] = -1;
                        }else{
                           $val['status'] = -3;
                        }
                    }
                    array_push($result, $val);
                }
            }
            return $result;
        }  else {
            return array();
        }
    }
    
    private function __getCmd($screen_id, $spot_id){
         $command = Cmd::model()->find("screen_id = {$screen_id} AND spot_id = {$spot_id}");
         if($command){
             return $command->cmd;
         }else{
             return 'pause';
         }
    }

    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    
}