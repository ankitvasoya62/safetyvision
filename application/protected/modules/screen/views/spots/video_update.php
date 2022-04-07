<link  href="/css/jquery-ui.min.css" rel="stylesheet">
<link  href="/css/jquery.timepicker.min.css" rel="stylesheet"/>
<script src="/js/bootstrap.file-input.js"></script>
<script src="/js/jquery.form.js"></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/jquery.timepicker.min.js"></script>
<div id="ctoolbar" class="box"></div>
<div id="cmain" class="box" ng-app="video" ng-controller="videoCtrl">
    <div class="panel panel-default" style="margin:0;">
        <div class="panel-heading">
            <ol class="breadcrumb" style="margin:0;">
                <li><?php echo Yii::t('lang', 'Create new spot'); ?></li>
                <li class="active">video cover</li>
            </ol>
        </div>
        <div class="panel-body">
            <?php if ($step == 0) { ?>
                <style>
                    #preview-pane{display: none;}
                    .jcrop-holder #preview-pane {
                        display: block;
                        position: absolute;
                        z-index: 1;
                        right: -480px;
                        padding: 6px;
                        border: 1px rgba(0,0,0,.4) solid;
                        background-color: #ddd;
                        -webkit-border-radius: 6px;
                        -moz-border-radius: 6px;
                        border-radius: 6px;
                        -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
                        -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
                        box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
                    }
                    #preview-pane .preview-container {width: 320px;height: 240px;overflow: hidden;}
                    #crop-pane{width:640px;height:360px;border: 2px solid #ddd180; background: url('/images/empty.gif');}
                    .image-div{width: 640px;}
                    .image-ul li{float: left; width: 160px; text-align: center;background: #ddd;}
                    .image-ul li input{width:60px; margin: 0;}
                </style>
                <link  href="/css/jquery.Jcrop.min.css" rel="stylesheet">
                <script src="/js/jquery.Jcrop.min.js"></script>
                <script src="/js/image_update.js"></script>
                <div class="row">
                    <table style="width:640px;">
                        <tr>
                            <td colspan="2">
                                <div class="input-group" style="margin-bottom:10px;">
                                    <div class="input-group-addon"><?php echo Yii::t('lang', 'Title'); ?>:</div>
                                    <input class="form-control" type="text" required="required" name="name" id="spot-title" value="<?php echo $model->title; ?>"/>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <form action="/screen/spots/upload" id="uploadForm" method="POST" enctype="multipart/form-data">
                                    <input type="hidden"  name="token" value="<?php echo $token; ?>">
                                    <input type="file" title="Click to browse" name="file" id="upload-file" class="btn-info">
                                </form>
                            </td>
                            <th style="width:60px;"><button type="button" class="btn btn-info" id="upload"><span class="glyphicon glyphicon-upload"></span>Upload</button></th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                &nbsp;
                                <input type="hidden" name="image[X]" value="" id="crop_X"/>
                                <input type="hidden" name="image[Y]" value="" id="crop_Y"/>
                                <input type="hidden" name="image[Width]" value="" id="crop_Width"/>
                                <input type="hidden" name="image[Height]" value="" id="crop_Height"/>
                                <input type="hidden" name="image[token]" value="<?php echo $token; ?>" id="crop_token" />
                                <input type="hidden" name="image[id]" value="<?php echo $model->id; ?>" id="crop_id" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="crop-pane" data_src="<?php echo $res['origin_image_file']; ?>" data_id="<?php echo $model->id; ?>"></div>
                                <div class="image-div">
                                    <ul class="image-ul">
                                        <li>
                                            <div class="input-group">
                                                <div class="input-group-addon">X:</div>
                                                <input class="form-control" type="number" min="0" id="x">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="input-group">
                                                <div class="input-group-addon">Y:</div>
                                                <input class="form-control" type="number" min="0" id="y">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="input-group">
                                                <div class="input-group-addon">Width:</div>
                                                <input class="form-control" type="number" min="0" id="width">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="input-group">
                                                <div class="input-group-addon">Height:</div>
                                                <input class="form-control" type="number" min="0" id="height">
                                            </div>
                                        </li>
                                    </ul>
                                    <div style="clear:both;"></div>
                                </div>
                                <div id="preview-pane">
                                    <div class="preview-container"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div style="margin-top: 5px;"><button class="btn btn-primary"  id="submit-button">Next</button></div>
                </div>
            <?php } else if ($step == 1) { ?>
                <script src="/js/video_update.js"></script>
                <style>
                    #video-pane{width:640px;height:480px;border: 2px solid #ddd180px; background: url('/images/empty.gif');}
                    #video-pane #loading-status{width:640px;height:30px;line-height: 30px; font-weight: bold; text-indent:5px; font-size: 14px; font-style: italic; display: none;}
                    #video-pane #loaded-video video{width:640px;height:480px; display: none; line-height: 480px;}
                    #progress-wrap{display:none;width: 640px;height: 16px; line-height: 16px;}
                    #progress{width: 160px;height: 16px; display: inline-block; background: #f7f7f7;}
                    #progress .progress_speed{width: 0%; height: 16px;background-image:-webkit-linear-gradient(to left, #499049, #61c261);background-image:linear-gradient(to left,#61c261,#499049);display: block;}
                    #progressText{display: inline-block; margin: 0 5px; height: 16px; line-height: 16px;border-radius:20px; position: relative; top: -4px; font-weight: bold; font-style: italic;}
                </style>
                <div class="row" id="spot-form" data_id="<?php echo $model->id; ?>">
                    <table style="width:640px;">
                        <tr>
                            <td>
                                <form action="/screen/spots/uploadVideo" id="uploadForm" method="post" enctype="multipart/form-data">
                                    <input type="hidden"  name="token" value="<?php echo $token; ?>" id="token">
                                    <input type="file" title="Click to browse" name="file" id="upload-file" class="btn-info">
                                </form>
                            </td>
                            <th style="width:60px;"><button type="button" class="btn btn-info" id="upload"><span class="glyphicon glyphicon-upload"></span>Upload</button></th>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="loading-span">Please wait while video file is uploading...</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" id="upload_status">
                                <p id="progress-wrap"><span id="progress"><span class="progress_speed"></span></span><span id="progressText">20%</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="video-pane">
                                    <div id="loading-status"></div>
                                    <div id="loaded-video" data_src="<?php echo $res['video']; ?>">
                                        <video src="<?php echo $res['video']; ?>" autoplay width="100%" type="video/mp4" controls="" autoplay></video>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="video[token]" value="<?php echo $token; ?>" id="video_token" />
                            </td>
                        </tr>
                    </table>
                    <div style="margin-top: 15px;"><button class="btn btn-primary"  id="submit-button" disabled>Next</button></div>
                </div>
            <?php } else if ($step == 2) { ?>
                <script src="/js/video_update.js"></script>
                <style>
                    #spot-form tr td:first-child{text-align: right; padding-right: 10px;}
                    #screen-panel .screen-left{width:40%;display: inline-block;}
                    #screen-panel .screen-right{width:55%;display: inline-block; text-align: right;}
                    #screen-panel .screen-checked-left{width: 90%; display: inline-block;}
                    #screen-panel .screen-checked-right{width: 8%;display: inline-block;}
                    a.checked_on{width:16px; height: 16px; background: url(/images/checked.png) left center no-repeat; display: inline-block; margin-bottom: 7px;}
                    a.checked_off{width:16px; height: 16px; background: url(/images/unchecked.png) left center no-repeat; display: inline-block; margin-bottom: 7px;}
                    #screen-panel .screen-ul-panel li{line-height: 30px; height: 30px; border-bottom: 1px solid #ccc;}
                    #screen-panel .screen-ul-panel li:last-of-type{border-bottom: none;}
                    #screen-panel .screen-checked-left{color: #000; font-weight: bold;}
                    #spot-form .form-control{width:420px; display: inline-block;}
                    #spot-form .datepicker{width:400px; display: inline-block;}
                </style>
                <div class="row" id="spot-form" data_id="<?php echo $model->id; ?>">
                    <table style="width:600px;">
                        <tr>
                            <td>
                                <label for="spot-owner" class="control-label"><?php echo Yii::t('lang', 'Additional Spot Owner'); ?>:</label>
                            </td>
                            <td>
                                <input value="<?php echo $model['additional_owner']; ?>" class="form-control" type="text" name="name" id="spot-owner"/>
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td>
                                <label for="spot-start-date" class="control-label"><?php echo Yii::t('lang', 'From date'); ?>:</label>
                            </td>
                            <td>
                                <input class="form-control datepicker" type="text" id="spot-start-date" value="<?php echo date("D.d.m.Y", substr($model['start_date'], 0, 10)); ?>"/>
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td>
                                <label for="spot-stop-date" class="control-label"><?php echo Yii::t('lang', 'To date and including'); ?>:</label>
                            </td>
                            <td>
                                <input class="form-control datepicker" type="text" id="spot-stop-date" value="<?php echo date("D.d.m.Y", substr($model['stop_date'], 0, 10)); ?>"/>
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td>
                                <label for="spot_start_hh" class="control-label"><?php echo Yii::t('lang', 'Start Time'); ?>:</label>
                            </td>
                            <td>
                                <input class="form-control" type="text" id="spot_start_hh" value="<?php echo $model['start_hh']; ?>"/>
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td>
                                <label for="spot_stop_hh" class="control-label"><?php echo Yii::t('lang', 'Stop Time'); ?>:</label>
                            </td>
                            <td>
                                <input class="form-control" type="text" id="spot_stop_hh" value="<?php echo $model['stop_hh']; ?>"/>
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td style="height:16px; line-height: 16px;">
                                <label for="spot-stop-date" class="control-label"><?php echo Yii::t('lang', 'Selected screens'); ?>:</label>
                            </td>
                            <td>
                                <div style="height:16px; line-height: 16px;">
                                    <a title="Select all" class="screens-all o control-label"></a>
                                    <a title="Deselect all" class="screens-none o control-label"></a>
                                    <span class="select-screens-info text control-label"> ( <span id="screen-number">All</span> screens are selected )</span>
                                </div>
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><button class="btn btn-primary"  id="spot-submit-button">Save</button></td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" value="<?php echo $token; ?>" id="spot_token" />
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <div class="panel panel-default" id="screen-panel">
                                    <div class="panel-heading">
                                        <span class="screen-left">
                                            <a class="spread" id="screen-control"></a>
                                            <span>SafetyVision(<span id="screen_count"><?php echo count($screens); ?></span>)</span>
                                        </span>
                                        <span class="screen-right">
                                            <a title="Select all" class="screens-all o"></a>
                                            <a title="Deselect all" class="screens-none o"></a>
                                        </span>
                                    </div>
                                    <div class="panel-body" id="screen-content">
                                        <ul class="screen-ul-panel">
                                            <?php
                                            if (!empty($screens)) {
                                                foreach ($screens as $val) {
                                                    ?>
                                                    <li><span class="screen-checked-left"><?php echo $val['name']; ?></span><span class="screen-checked-right"><a href="javascript:void(0);" class="target checked_on" data-screen-id="<?php echo $val['screen_id']; ?>"></a></span></li>
                                                    <?php
                                                }
                                            } else {
                                                echo '<li>No Screens</li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            <div class="modal fade" id="message" tabindex="-2" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Spot Message</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" role="alert">
                                <strong style="padding:8px; font-size: 16px;" id="error"></strong>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>