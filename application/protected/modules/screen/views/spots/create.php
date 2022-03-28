<div id="ctoolbar" class="box">
   
</div>
<div id="cmain" class="box">
    <div id="cheader" class="title">
        <span><?php echo Yii::t('lang', 'Create new spot'); ?> </span>
    </div>
    <div id="ccontent">
        <?php if ($step == 0) { ?>
            <div class="gulf_kpi_spot" data_step="0">
                <table cellspacing="10" cellpadding="10" class="finn_spot_form">
                    <tr>
                        <th class="finn_spot_title">Boat Name:</th>
                        <td id="image_type"><?php echo OisForm::ois_dropdown('spot_name', $type, '', '', 'finn_spot_select_single') ?></td>
                        <td><a class="edit" href="javascript:void(0);" id="spot_setting"></a></td>
                    </tr>
                    <tr>
                        <th colspan="3"><button class="btn btn-primary" id="spot_save">Next</button></th>
                    </tr>
                </table>
            </div>
        <?php } elseif ($step == 1) { ?>
            <div class="gulf_kpi_spot" data_step="1" data_image_id="<?php echo $image_id; ?>" data_spot_id="0">
                <div id="gulf_template">
                    <div id="template_header">
                        <?php
                        $images = Images::model()->findByPk($image_id);
                        $name = null;
                        if ($images) {
                            $name = $images->name;
                        }
                        ?>
                        <p style="padding-top: 18px; text-indent:135px; color:#335e8d ; font-size: 24px;"><?php echo $name; ?></p>
                    </div>
                    <div id="template_banner"></div>
                    <div id="template_content">
                        <div id="left_content">
                            <div class="left_wrapper">
                                <?php $content = Images::model()->getContentImages($image_id); ?>
                                <?php if (!empty($content)) { ?>
                                    <img src="<?php echo '/download/' . $content['source']; ?>" width="300" height="200" id="img_content" data_content="<?php echo '/download/' . $content['source']; ?>">
                                <?php } else { ?>
                                    <img src="/images/dreamwall/20130802111022273_c.jpg" width="300" height="200" id="img_content" data_content="">
                                <?php } ?>
                            </div>
                        </div>
                        <div id="right_content">
                            <div class="right_wrapper">
                                <?php
                                $gulf_info = GulfKpi::loadRemoteData($name);
                                ?>
                                <div class="left_box">
                                    <dl class="gulf_info">
                                        <dt>ORDERS<em style="float: right; font-style: normal;"><?php echo $gulf_info['OrderTotal']; ?> &nbsp;</em></dt>
                                        <dd>Approved<em style="float: right; font-style: normal;"><?php echo $gulf_info['OrderApproved']; ?>&nbsp;</em></dd>
                                        <dd>Order sent<em style="float: right; font-style: normal;"><?php echo $gulf_info['OrderSent']; ?>&nbsp;</em></dd>
                                        <dd>In progress<em style="float: right; font-style: normal;"><?php echo $gulf_info['OrderInProgress']; ?>&nbsp;</em></dd>
                                        <dd>On Order<em style="float: right; font-style: normal;"><?php echo $gulf_info['OrderOnOrder']; ?>&nbsp;</em></dd>
                                        <dd>Received Agent<em style="float: right; font-style: normal;"><?php echo $gulf_info['OrderReceivedAgent']; ?>&nbsp;</em></dd>
                                        <dd>Partly Received<em style="float: right; font-style: normal;"><?php echo $gulf_info['OrderPartlyReceived']; ?>&nbsp;</em></dd>
                                    </dl>
                                </div>
                                <div class="right_box">
                                    <dl class="gulf_info">
                                        <dt>JOBS<em style="float: right; font-style: normal;"><?php echo $gulf_info['JobsTotal']; ?>&nbsp;</em></dt>
                                        <dd>Upcoming next 3d<em style="float: right; font-style: normal;"><?php echo $gulf_info['JobsUpcomming3d']; ?>&nbsp;</em></dd>
                                        <dd>Upcoming 3d -9d<em style="float: right; font-style: normal;"><?php echo $gulf_info['JobsUpcomming3d9d']; ?>&nbsp;</em></dd>
                                    </dl>
                                    <div style="height:15px;"></div>
                                    <dl class="gulf_info">
                                        <dt>CERTIFICATES<em style="float: right; font-style: normal;"><?php echo $gulf_info['CertificatesTotal']; ?>&nbsp;</em></dt>
                                        <dd>Upcoming next 3w<em style="float: right; font-style: normal;"><?php echo $gulf_info['CertUpcomming3w']; ?>&nbsp;</em></dd>
                                        <dd>Upcoming 3d -9d<em style="float: right; font-style: normal;"><?php echo $gulf_info['CertUpcomming3w9w']; ?>&nbsp;</em></dd>
                                    </dl>
                                </div>
                                <div style="clear: both;"></div>
                                <div style="height:25px;"></div>
                                <div class="update_box">Updated <?php if($gulf_info['RecordFlag']){ echo GulfKpi::formateLocalDate($gulf_info['LastUpdate']); }else{echo $gulf_info['LastUpdate'];} ?></div>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <div id="template_footer"></div>
                </div>
                <div style="margin-top: 5px;"><button class="btn btn-primary" id="spot_save">Next</button></div>
            </div>
        <?php } ?>
    </div>
</div>
<script src="/js/gulf.js"></script>