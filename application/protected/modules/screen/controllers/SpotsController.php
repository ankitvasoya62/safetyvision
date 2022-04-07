<?php

class SpotsController extends Controller {

    protected $uploadKey = null;
    protected $isUploading = false;

    public function actionType() {
        $this->render('type');
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $type = Yii::app()->request->getParam('type');
        if (isset($type)) {
            if ($type == 'video') {
                $this->redirect(array('video'));
            }
        } else {
            Yii::app()->end();
        }
    }

    public function actionVideo() {
        $step = Yii::app()->request->getParam('step', 0);
        $model = new Convert;

        if ($step == 0) {
            $token = Yii::app()->request->getParam('token', $this->__createKey());
            $paramData = json_encode(array('status' => $step));
            $model->token = $token;
            $model->params = $paramData;
            $model->save(false);
            $this->render('video', array('step' => $step, 'token' => $token));
        } else if ($step == 1) {
            session_start();
            $token = Yii::app()->request->getParam('token');
            $conversion = Convert::model()->findByPk($token);
            if (!isset($conversion)) {
                 $paramData = json_encode(array('status' => $step));
                $model->token = $token;
                $model->params = $paramData;
                $model->save(false);
            }
            $this->render('video', array('step' => $step, 'token' => $token));
        } else if ($step == 2) {
            $screens = Screen::model()->getScreensByCustomerId();
            $token = Yii::app()->request->getParam('token');
            $conversion = Convert::model()->findByPk($token);
            if (!isset($conversion)) {
                $paramData = json_encode(array('status' => $step));
                $model->token = $token;
                $model->params = $paramData;
                $model->save(false);
            }
            $this->render('video', array('step' => $step, 'token' => $token, 'screens' => $screens));
        }
    }

    public function actionUpdateToken() {
        $token = Yii::app()->request->getParam('token');
        $name = Yii::app()->request->getParam('name');
        $result = array('status' => TRUE);
        if (!empty($token)) {
            $this->__resetKey($token, array('name' => $name));
        } else {
            $result = array('status' => FALSE);
        }
        echo json_encode($result);
    }

    public function actionUpdate() {
        $id = Yii::app()->request->getParam('id', 0);
        $step = Yii::app()->request->getParam('step', 0);
        $model = Spots::model()->findByPk($id);
        if ($step == 0) {
            $this->render('video_update', array(
                'model' => $model,
                'step' => 0,
                'token' => $this->__createKey(),
                'res' => json_decode($model->resource, true),
            ));
        } else if ($step == 1) {
            $token = Yii::app()->request->getParam('token');
            $this->render('video_update', array(
                'model' => $model,
                'step' => 1,
                'token' => $token,
                'res' => json_decode($model->resource, true),
            ));
        } else if ($step == 2) {
            $screens = Screen::model()->getScreensByCustomerId();
            $token = Yii::app()->request->getParam('token');
            $this->render('video_update', array('model' => $model,'step' => 2, 'token' => $token, 'screens' => $screens));
        }
    }

    public function actionSave() {
        $spot_id = Yii::app()->request->getParam('spot_id', 0);
        $result = array('status' => FALSE);
        if ($spot_id !== 0) {
            $model = Spots::model()->findByPk($spot_id);
            
            $spot = Yii::app()->request->getParam('spot');
            if (isset($spot['token'])) {
                $param = $this->__getKey($spot['token']);
                if ($param) {
                    if (array_key_exists('src', $param) != 1) {
                        $resourceData = json_decode($model->resource);
                        $src = $resourceData->origin_image_file;
                        $name = $resourceData->origin_image_name;
                        $param['src'] = $src;
                        $param['name'] = $name;                        
                    }  
                    if (array_key_exists('filesize', $param) != 1) {
                        $param['filesize'] = $model['filesize'];
                    }
                    if (array_key_exists('video', $param) != 1) {
                        $param['video'] = $resourceData->video;
                    }
                    if (array_key_exists('videoName', $param) != 1) {
                        $param['videoName'] = $resourceData->origin_video_name;
                    }
                    if (array_key_exists('extension', $param) != 1) {
                        $param['extension'] = $resourceData->origin_video_extension;
                    }
                    if (array_key_exists('url', $param) != 1) {
                        $param['url'] = $resourceData->video;
                    }

                    $model->owner = trim($spot['owner']);
                    $model->additional_owner = trim($spot['owner']);
                    $model->title = $param['title'];
                    $model->user_id = 1;
                    $model->customer_id = 1;
                    if (!empty($spot['start_date'])) {
                        $model->start_date = strtotime($spot['start_date']);
                    } else {
                        $model->start_date = time();
                    }
                    if (!empty($spot['stop_date'])) {
                        $model->stop_date = strtotime($spot['stop_date']);
                    }
                    
                    if (!empty($spot['start_hh'])) {
                        $model->start_hh = $spot['start_hh'];
                    }
                    if (!empty($spot['stop_hh'])) {
                        $model->stop_hh = $spot['stop_hh'];
                    }
                    
                    $model->screens = implode(',', $spot['screen_id']);
                    $model->lastedit = time();
                    
                    $model->filesize = $param['filesize'];

                    $model->resource = json_encode(array(
                        'origin_image_file' => $param['src'],
                        'origin_image_name' => $param['name'],
                        'image' => $param['cover'],
                        'origin_video_file' => $param['video'],
                        'origin_video_name' => $param['videoName'],
                        'origin_video_extension' => $param['extension'],
                        'video' => $param['url'],
                    ));
                    if ($model->update()) {
                        Yii::app()->memcache->set('screen_1', $model->screens);
                        Yii::app()->memcache->delete($spot['token']);
                        // SpotsPos::model()->addPlaylist($model->id, $model->screens);
                        $result = array('status' => TRUE);
                    }
                }
            }
        } else {
            $model = new Spots;
            $spot = Yii::app()->request->getParam('spot');
            if (isset($spot['token'])) {
                $param = $this->__getKey($spot['token']);
                if ($param) {
                    $model->owner = trim($spot['owner']);
                    $model->additional_owner = trim($spot['owner']);
                    $model->title = $param['title'];
                    $model->user_id = 1;
                    $model->customer_id = 1;
                    $model->type = $param['extension'];
                    if (!empty($spot['start_date'])) {
                        $model->start_date = strtotime($spot['start_date']);
                    } else {
                        $model->start_date = time();
                    }
                    if (!empty($spot['stop_date'])) {
                        $model->stop_date = strtotime($spot['stop_date']);
                    }
                    if (!empty($spot['start_hh'])) {
                        $model->start_hh = $spot['start_hh'];
                    }
                    if (!empty($spot['stop_hh'])) {
                        $model->stop_hh = $spot['stop_hh'];
                    }
                    $model->screens = implode(',', $spot['screen_id']);
                    $model->created = time();
                    $model->filesize = $param['filesize'];

                    $model->resource = json_encode(array(
                        'origin_image_file' => $param['src'],
                        'origin_image_name' => $param['name'],
                        'image' => $param['cover'],
                        'origin_video_file' => $param['video'],
                        'origin_video_name' => $param['videoName'],
                        'origin_video_extension' => $param['extension'],
                        'video' => $param['url'],
                    ));
                    if ($model->save()) {
                        Yii::app()->memcache->set('screen_1', $model->screens);
                        Yii::app()->memcache->delete($spot['token']);
                        SpotsPos::model()->addPlaylist($model->id, $model->screens);
                        $result = array('status' => TRUE);
                    }
                }
            }
        }
        echo json_encode($result);
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Spots');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    private function __createKey() {
        return uniqid();
    }

    private function __getKey($key) {
        return Yii::app()->memcache->get($key);
    }

    private function __resetKey($key, $data = array()) {
        if (Yii::app()->memcache->get($key)) {
            $store = Yii::app()->memcache->get($key);
        } else {
            $store = array();
        }

        if (!empty($data)) {
            foreach ($data as $index => $val) {
                $store[$index] = $val;
            }
        }
        Yii::app()->memcache->set($key, $store, 7200);
    }

    private function __clearKey($key) {
        Yii::app()->memcache->delete($key);
    }

    public function actionUpload() {
        $token = Yii::app()->request->getParam('token');
        $basePath = Yii::app()->basePath . '/../upload/';
        $dir = date('Ymd');
        $source = 'images';
        if (!file_exists($basePath . $dir)) {
            mkdir($basePath . $dir, 0777);
        }
        if (!file_exists($basePath . $source)) {
            mkdir($basePath . $source, 0777);
        }

        $file = CUploadedFile::getInstanceByName('file');
        $name = uniqid() . "." . $file->getExtensionName();
        $file->saveAs('upload/' . $source . '/' . $name);

        $this->__resetKey($token, array('src' => '/upload/' . $source . '/' . $name, 'name' => $file->getName(),'extension' => $file->getExtensionName()));

        echo json_encode(array('src' => '/upload/' . $source . '/' . $name));
    }

    public function actionUploadVideo() {
        $token = Yii::app()->request->getParam('token');
        $basePath = Yii::app()->basePath . '/../upload/';
        $source = 'video';
        if (!file_exists($basePath . $source)) {
            mkdir($basePath . $source, 0777);
        }
        $file = CUploadedFile::getInstanceByName('file');
        if ($file) {
            $name = $token . "." . $file->getExtensionName();
            if(strtolower($file->getExtensionName()) == 'mp4'){
                 $file->saveAs('download/' . $token . '.mp4');
                 $filesize = filesize('download/' . $token . '.mp4');
                 $this->__resetKey($token, array('url' => '/download/' . $token . '.mp4', 'videoName' => $file->getName(),'filesize' => $filesize, 'video' => '/download/' . $token . '.mp4', 'extension' => $file->getExtensionName()));
                 echo json_encode(array('src' => '/upload/' . $source . '/' . $name));
            }else{
                $file->saveAs('upload/' . $source . '/' . $name);
                $this->__resetKey($token, array('video' => '/upload/' . $source . '/' . $name,
                    'videoName' => $file->getName(),
                    'extension' => $file->getExtensionName(),
                    'filepath' => $name));
                echo json_encode(array('src' => '/upload/' . $source . '/' . $name));
            }
        } else {
            echo json_encode(array('src' => null));
        }
    }

    public function actionConvert() {
        $token = Yii::app()->request->getParam('token');
        $result = array('status' => FALSE);
        if ($token) {
            $param = $this->__getKey($token);
            
//            echo '<pre>';
//            print_r($param);
//            exit();
            
            
            if ($param) {
                $basePath = Yii::app()->basePath . '/..';
                if (file_exists($basePath . $param['video'])) {
                    if($param['extension'] == 'mp4'){
                        $result = array('status' => TRUE, 'msg' => 'Done');
                    }else{
                        $url = Yii::app()->params->convert_host . '?token=' . $token . '&filepath=' . $param['filepath'];
                        $is_lock_request_key = 'is_locked' . $token;
                        if (Yii::app()->memcache->get($is_lock_request_key)) {
                            $result = array('status' => TRUE, 'msg' => 'Ready to convert');
                            Yii::app()->memcache->delete($is_lock_request_key);
                        } else {
                            Yii::app()->memcache->set($is_lock_request_key, TRUE);
                            Helpers::curlGet($url);
                            $result = array('status' => TRUE, 'msg' => 'Start with convertion service.');
                        }
                    }
                } else {
                    $result = array('status' => FALSE, 'msg' => 'Uploading now');
                }
            } else {
                $result['msg'] = 'Operation is timeout.';
            }
        } else {
            $result['msg'] = 'Param error.';
        }
        echo json_encode($result);
    }

    public function actionGetConvertProgress() {
        $token = Yii::app()->request->getParam('token');
        $result = array('status' => FALSE);
        $cache = $this->__getKey($token);

        if(isset($cache['url'])){
            $result = array('status' => TRUE, 'src' => '/download/' . $token . '.mp4', 'percent' => '100%');
        }else{
            // $extension = pathinfo($cache['video'], PATHINFO_EXTENSION);
            // $newextension = "mp4";
            // $uploadPath = Yii::getPathOfAlias('webroot') . '/upload/video/' . $token . "." . $extension;
            // $downloadPath = Yii::getPathOfAlias('webroot') . '/download/' . $token . "." . $newextension;
            // $args = array(
            //     'input_file' => $uploadPath, 
            //     'output_file' => $downloadPath, 
            //     'type' => 'video',
            //     'audio_bit_rate' => '20k', 
            //     'video_bit_rate' => '10k', 
            //     'thumbnail_image' => '',
            //     'thumbnail_generation' => 'no',
            //     'thumbnail_size' => ''
            // );
            
            // echo Yii::app()->ffmpeg->ffmpeg($args);
            // exit();
            $targetVideoPath = $token . ".mp4";
            $extension = pathinfo($cache['video'], PATHINFO_EXTENSION);
            $newextension = "mp4";
            $newfilename = basename($cache['video'], $extension).$newextension;
            $uploadPath = Yii::getPathOfAlias('webroot') . '/upload/video/' . $cache['filepath'];
            $downloadPath = Yii::getPathOfAlias('webroot') . '/download/' . $token . "." . $newextension;

            shell_exec("ffmpeg -i $uploadPath $downloadPath");
            // shell_exec("ffmpeg -i $uploadPath -c:a copy -c:v libx264 -preset superfast -profile:v baseline $downloadPath");
            // exit();
            // copy($uploadPath . $cache['filepath'] , $downloadPath . $downloadPath);
            $is_lock_request_key = 'is_locked' . $token;
            Yii::app()->memcache->delete($is_lock_request_key);
            $this->__resetKey($token, array('url' => '/download/' . $token . '.mp4', 'filesize' => 0));
            $result = array('status' => TRUE, 'src' => '/download/' . $token . '.mp4', 'percent' => '100%');
            // $conversion = Convert::model()->findByPk($token);
            // if ($conversion) {
            //     $param = json_decode($conversion->params, TRUE);
            //     if ($param['status'] == 2) {
            //         $is_lock_request_key = 'is_locked' . $token;
            //         Yii::app()->memcache->delete($is_lock_request_key);
            //         $this->__resetKey($token, array('url' => '/download/' . $token . '.mp4', 'filesize' => 0));
            //         $result = array('status' => TRUE, 'src' => '/download/' . $token . '.mp4', 'percent' => '100%');
            //     } else if ($param['status'] == 1) {
            //         $result['percent'] = $param['percent'];
            //     } else if ($param['status'] == 0) {
            //         $result['percent'] = '0%';
            //     } else {
            //         $result['percent'] = 'conversion server error occurred';
            //     }
            // }
        }
        echo json_encode($result);
    }

    public function actionHandleImage() {
        $result = array('status' => FALSE);
        $param = Yii::app()->request->getParam('image');
        $title = Yii::app()->request->getParam('title');
        $basePath = Yii::app()->basePath . '/../upload/';
        $dir = date('Ymd');
        if (!file_exists($basePath . $dir)) {
            mkdir($basePath . $dir, 0777);
        }
        if (!empty($param)) {
            $token = $param['token'];
            if (isset($param['id'])) {
                $spot = Spots::model()->findByPk($param['id']);
                if ($spot) {
                    $res = json_decode($spot->resource, true);
                    $target = ltrim($res['origin_image_file'], '/');
                    $image = new Image($target);
                    $image->crop($param['width'], $param['height'], $param['y'], $param['x'])->quality(100);
                    $image->save('upload/' . $dir . '/' . $res['origin_image_name']);
                    $this->__resetKey($token, array('cover' => '/upload/' . $dir . '/' . $res['origin_image_name'], 'title' => $title, 'crop' => array('w' => $param['width'], 'h' => $param['height'], 'x' => $param['x'], 'y' => $param['y'])));
                }
                $result = array('status' => TRUE, 'token' => $token);
            } else {
                $history = $this->__getKey($token);
                if (!empty($history)) {
                    $target = ltrim($history['src'], '/');
                    $image = new Image($target);
                    $image->crop($param['width'], $param['height'], $param['y'], $param['x'])->quality(100);
                    $name = date('YmdHis') . '_' . uniqid() . '.' . $history['extension'];
                    $image->save('upload/' . $dir . '/' . $name);
                    $this->__resetKey($token, array('cover' => '/upload/' . $dir . '/' . $name, 'title' => $title, 'crop' => array('w' => $param['width'], 'h' => $param['height'], 'x' => $param['x'], 'y' => $param['y'])));
                    $result = array('status' => TRUE, 'token' => $token);
                } else {
                    $result = array('status' => FALSE, 'msg' => 'Missing cache.');
                }
            }
        } else {
            $result = array('status' => FALSE, 'msg' => 'Param error.');
        }
        echo json_encode($result);
    }

    public function actionDelete() {
        $pos_id = Yii::app()->request->getParam('pos_id');
        $result = array('status' => false);

        if ($pos_id) {
            $model = SpotsPos::model()->findByPk($pos_id);
            $model->deleted = 'y';
            if ($model->update()) {
                $result = array('status' => true);
            }
        }
        echo json_encode($result);
    }

    public function actionPublish() {
        $pos_id = Yii::app()->request->getParam('pos_id');
        $type = Yii::app()->request->getParam('type');
        $spot_id = Yii::app()->request->getParam('spot_id');
        $result = array('status' => false);
        if ($pos_id) {
            $model = SpotsPos::model()->findByPk($pos_id);

            $spot = Spots::model()->findByPk($spot_id);

            $status = VSCommon::checkSpotStatus($spot->start_date, $spot->stop_date, $spot->start_hh, $spot->stop_hh);

            if ($type == 'y') {
                $model->public = 'n';
                if ($status == 3) {
                    $status = -3;
                } elseif ($status == 2) {
                    $status = -2;
                } else {
                    $status = -1;
                }
            } else {
                $model->public = 'y';
                if ($status == 3) {
                    $status = 3;
                } elseif ($status == 2) {
                    $status = 2;
                } else {
                    $status = 1;
                }
            }

            if ($model->update()) {
                $result = array('status' => true, 'type' => $model->public, 'status' => $status);
            }
        }
        echo json_encode($result);
    }

    public function actionCmd() {
        $screen_id = Yii::app()->request->getParam('screen_id', null);
        $spot_id = Yii::app()->request->getParam('spot_id', null);
        $cmd = Yii::app()->request->getParam('cmd');
        $result = array('status' => false);
        if (!empty($screen_id) && !empty($spot_id)) {
            $command = Cmd::model()->find("`screen_id` = {$screen_id} AND `spot_id` = {$spot_id}");
            if ($command) {
                $command->cmd = $cmd;
                if ($command->update()) {
                    $result['status'] = true;
                }
            } else {
                $command = new Cmd();
                $command->screen_id = $screen_id;
                $command->spot_id = $spot_id;
                $command->cmd = $cmd;
                if ($command->save()) {
                    $result['status'] = true;
                }
            }
        }
        echo json_encode($result);
    }

    public function actionEncrypt() {
        $result = array('status' => false);
        $spot_id = Yii::app()->request->getParam('spot_id', NULL);
        if ($spot_id) {
            $sid = base64_encode($spot_id);
            $sname = Helpers::encrypt('sid', 'E', 'safetyvision');
            $links = "http://" . $_SERVER["HTTP_HOST"] . "/screen/preview/spot/" . $sname . '/' . $sid . '.html';
            $result = array('status' => true, 'link' => $links);
        } else {
            $result = array('status' => false);
        }
        echo json_encode($result);
    }

}
