<style>
    input.form-control{margin:0;}
    td select{margin: 0;}
    tr th:nth-child(1){ font-weight: bold; font-size: 16px; height: 41px; line-height: 41px; padding: 0; text-align: right; padding-right: 10px;}
    .parent_thead{background: none repeat scroll 0 0 #dadfe3;}
    .children_thead{background: none repeat scroll 0 0 #f0f1f2;}
    .spot_table tbody tr{height: 30px; line-height: 30px;}
    .table .even{background: none repeat scroll 0 0 #f0f1f2;}
    .children_thead tr{padding:0; height: 20px;}
    .children_thead th{text-align: center;}
    .hightlight{background:#e1f579;}
    .parent_tr:hover{background:#e1f579;}
    table td{font-weight: bold;color: #333;}
    #fulldemo .gate-list{width: 400px; float: left; margin-left: 50px;}
    #fulldemo .gate-list h4{margin: 5px 0; color: #2887bf;}
    .disabled{background: #eee;}
    
    .public_a{width: 16px; height: 16px; display: inline-block;}
    .public_a span{width: 16px; height: 16px;}
    .publish_v{width: 16px; height: 16px; background: url("/images/publish_v.gif") no-repeat left top;}
    .publish_v_clock{width: 16px; height: 16px; background: url("/images/publish_v_clock.gif") no-repeat left top;}
    .publish_p_clock{width: 16px; height: 16px; background: url("/images/publish_p_clock.gif") no-repeat left top;}
    
    .publish_x{width: 16px; height: 16px; background: url("/images/publish_x.gif") no-repeat left top;}
    .publish_x_clock{width: 16px; height: 16px; background: url("/images/publish_x_clock.gif") no-repeat left top;}
    .publish_s_clock{width: 16px; height: 16px; background: url("/images/publish_s_clock.gif") no-repeat left top;}
    
</style>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular.min.js"></script>
<?php
$init = array('spot.create' => 0,'spot.edit'=>0, 'spot.delete'=>0, 'screen.create' => 0, 'screen.edit'=>0, 'screen.delete'=>0, 'screen.command'=>0);
$access = AuthManage::checkAccess($init);
?>
<div ng-app="screen" ng-controller="screenCtrl" ng-cloak>
    <div id="ctoolbar" class="box">
        <div class="fl text" style="max-height:30px;">
            <label for="screenTitle">Keyword : </label>
            <input id="inp_sea" class="input inp" type="text" name="screenTitle" ng-model= "search.$">
            <input type="submit" value="Search">
        </div>
        <ul id="tool-menu" class="tr" ng-controller="newScreenCtrl">
            <?php if ($access['spot.create']) { ?>
                <li class="menu-screen-new"><a href="javascript:void(0);" ng-click="addScreen()"><?php echo Yii::t('lang', 'New Screen'); ?></a></li>
            <?php } ?>
            <?php if ($access['screen.create']) { ?>
                <li class="menu-campain-new"><a href="/screen/spots/type"><?php echo Yii::t('lang', 'New safetyVideo'); ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div id="cmain" class="box">
        <div id="cheader" class="title" style="padding:0 0;">
            <span><?php echo Yii::t('lang', 'Screens'); ?> </span> <img src="/images/television.png" alt="" border="0" width="14" height="14" />
        </div>
        <div id="ccontent" style="background: #ffffff;min-width: 1000px;">
            <div ng-hide="isShowTable"><img src="/images/loading.gif"></div>
            <table class="table table-bordered" ng-show="isShowTable" id="table_screen">
                <thead class="parent_thead">
                    <tr>
                        <th style="width:8px;"><img src="/images/television.png"></th>
                        <th style="width:50px;">ID</th>
                        <th>Screen name</th>
                        <th>Customer</th>
                        <th>Size</th>
                        <th style="width:120px;">Action</th>
                    </tr>
                </thead>
                <tbody ng-repeat="item in items| filter:search.$">
                    <tr ng-class-even="'even'" ng-class="{hightlight:item.is_open}" class="parent_tr">
                        <td><a ng-class="showIcno(item.is_open)" ng-click="showPlaylist(item)"></a></td>
                        <th>{{item.screen_id}}</th>
                        <td>{{item.name}}</td>
                        <td>{{item.customer}}</td>
                        <td>{{item.width}} X {{item.height}}</td>
                        <td style="text-align: center;">
                            <a class="preview" ng-click="activeFullScreen(item)"></a>
                            <?php if($access['screen.edit']){ ?>
                            <a class="edit" ng-click="activeUpdateScreen(item)"></a>
                            <?php } ?>
                            <?php if($access['screen.delete']){ ?>
                            <a class="delete" ng-click="activeDeleteScreen(item.screen_id)"></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr ng-show="item.is_open">
                        <td colspan="6" style="padding:0;">
                            <table class="spot_table table table-bordered" style="margin:0;">
                                <thead class="children_thead">
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Pos</th>
                                        <th>Spot name</th>
                                        <th>Show owner</th>
                                        <th>Addtional owner</th>
                                        <th>File size</th>
                                        <th>Spot Type</th>
                                        <th>Time</th>
                                        <th>&nbsp;</th>
                                        <th style="text-align:center;">Command</th>
                                        <th style="text-align:center;">Status</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="spot in item.spots" ng-class="{disabled:spot.pc == 'n'}">
                                        <td style="text-align:center;">
                                            <a ng-class="{'publish_v':spot.status == '2','publish_v_clock':spot.status == '1','publish_p_clock':spot.status == '3','publish_x':spot.status =='-2','publish_x_clock':spot.status == '-1','publish_s_clock':spot.status== '-3' }" ng-click="publish(spot)"></a>
                                        </td>
                                        <td ng-bind="$index + 1" style="text-align:center;"></td>
                                        <td ng-bind="spot.title"></td>
                                        <td ng-bind="spot.owner" style="text-align:center;"><span ng-class="{'glyphicon':true,'glyphicon-ok-sign':spot.owner == ''}"></span></td>
                                        <td ng-bind="spot.additional_owner" style="text-align:center;"></td>
                                        <td ng-bind="spot.filesize" style="text-align:center;"></td>
                                        <td ng-bind="spot.type" style="text-align:center;"><span class="{{spot.type}}" title="{{spot.type}}"></span></td>
                                        <td ng-bind="spot.time_days" style="text-align:right;"></td>
                                        <td style="text-align:center;">
                                            <a><span class="glyphicon glyphicon-info-sign"></span></a>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php if ($access['screen.command']) { ?>
                                                <a href="" ng-click="command(item.screen_id, spot, 'play')"><span class="glyphicon glyphicon glyphicon-play"></a>
                                                <a href="" ng-click="command(item.screen_id, spot, 'pause')"><span class="glyphicon glyphicon glyphicon-pause"></a>
                                                <a href="" ng-click="command(item.screen_id, spot, 'update')"><span class="glyphicon glyphicon glyphicon-upload"></a>
                                            <?php } ?>
                                        </td>
                                        <td style="text-align:center;">{{spot.cmd}}</td>
                                        <td style="text-align: center;">
                                            <a title="copy link" class="copy-link o" ng-click="copy(spot)"></a>
                                            <a title="Preview" class="preview o" ng-click="preview(spot)"></a>
                                            <?php if($access['spot.edit']){ ?>
                                            <a title="Edit" class="edititem o" ng-click="edit(spot)"></a>
                                            <?php } ?>
                                            <?php if($access['spot.delete']){ ?>
                                             <a title="Archive" class="archive o" ng-click="delete($index, spot, item.spots)"></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align:center;"><a><span class="glyphicon glyphicon-fullscreen"></span></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="screen" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create Screen</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert" ng-hide="isValid">
                            <strong>Warning!</strong>{{message}}
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <th><?php echo Yii::t('lang', 'Screen name'); ?>:</th>
                                <td> <input type="text" class="form-control" required="required" ng-model="name" ng-change="validChange()"/></td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t('lang', 'Customer'); ?>:</th>
                                <td>
                                    <select ng-model="customer_id" class="form-control">
                                        <?php
                                        $customers = CHtml::listData(Customer::model()->findAll(), 'id', 'name');
                                        if (!empty($customers)) {
                                            foreach ($customers as $key => $val) {
                                                echo "<option value='{$key}'>{$val}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t('lang', 'Resolution ratio'); ?>:</th>
                                <td>
                                    <select ng-model="ratio" ng-change="ratioChange()" class="form-control">
                                        <option value="16:9">16:9</option>
                                        <option value="9:16">9:16</option>
                                        <option value="4:3">4:3</option>
                                        <option value="">Manual</option>
                                    </select>
                                </td>
                            </tr>
                            <tr ng-hide="isShow">
                                <th><?php echo Yii::t('lang', 'Resolution'); ?>:</th>
                                <td>
                                    <select ng-model="resolution" class="form-control">
                                        <option ng-repeat="list in ratioList" ng-value="list.key">{{list.key}}</option>
                                    </select>
                                </td>
                            </tr>
                            <tr ng-show="isShow">
                                <th><?php echo Yii::t('lang', 'Resolution'); ?>:</th>
                                <td><input type="number" ng-model="width" style="width: 60px;" ng-change="validChange()" min="1"/> X <input type="number" ng-model="height" style="width: 60px;" ng-change="validChange()" min="1"/></td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t('lang', 'Client password'); ?>:</th>
                                <td> <input type="text" class="form-control" required="required" ng-model="secret" ng-change="validChange()"/></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="saveScreen()">Save</button>
                    </div>
                </div>
            </div>
        </div><!-- Create/Update Screen -->

        <div class="modal fade" id="deleteScreen" tabindex="-2" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Delete Screen</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert">
                            <strong>Are you sure you want to delete this screen?</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="archiveScreen()">Delete</button>
                    </div>
                </div>
            </div>
        </div><!-- Delete Screen -->

        <div class="modal fade" id="fulldemo" tabindex="-3" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:1000px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{screen_name}}</h4>
                    </div>
                    <div class="modal-body">
                        <dl ng-repeat="spot in previewspots" class="gate-list">
                            <dt><video poster="{{spot.image}}" width="400" height="300" ng-src="{{spot.video}}" controls autobuffer></video></dt>
                            <dd><center><h4>{{spot.title}}</h4></center></dd>
                        </dl>
                    </div>
                    <div class="modal-footer" style="clear:both;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- Full Demo Video -->

        <div class="modal fade" id="spot_preview" tabindex="-4" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:1000px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{spot_name}}</h4>
                    </div>
                    <div class="modal-body">
                        <video poster="{{spot_image}}" width="100%" ng-src="{{spot_video}}" controls></video>
                    </div>
                    <div class="modal-footer" style="clear:both;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- Preview Spot -->

        <div class="modal fade" id="deleteSpot" tabindex="-5" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{spot_title}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert">
                            <strong>{{spot_message}}</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="deleteSpot()">Delete</button>
                    </div>
                </div>
            </div>
        </div><!-- Delete Spot -->

        <div class="modal fade" id="copy-link" tabindex="-6" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{spot_title}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" role="alert">
                            <strong>{{copy_link}}</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- Delete Spot -->

    </div>
</div>
<script type="text/javascript">
    angular.module('screen', []).constant('RATIO169', [{key: '1920X1080'}, {key: '1680X1050'}, {key: '1440X900'}, {key: '1366X768'}, {key: '1280X720'}, {key: '1280X768'}, {key: '1088X612'}, {key: '1072X600'}, {key: '1024X640'}, {key: '848X480'}, {key: '512X287'}])
            .constant('RATIO916', [{key: '1080X1920'}, {key: '1050X1680'}, {key: '900X1440'}, {key: '768X1366'}, {key: '720X1280'}, {key: '768X1280'}, {key: '612X1088'}, {key: '600X1072'}, {key: '640X1024'}, {key: '480X848'}, {key: '287X512'}])
            .constant('RATIO43', [{key: '1280X1024'}, {key: '1152X864'}, {key: '1024X768'}, {key: '800X600'}])
            .controller('newScreenCtrl', function ($scope) {
                $scope.isShow = false;
                $scope.addScreen = function () {
                    $scope.clearForm();
                    $('#screen').modal('toggle');
                };
            }).controller('screenCtrl', function ($scope, RATIO169, RATIO916, RATIO43, $http) {
        $scope.screen_id = 0;
        $scope.isShowTable = false;
        $scope.isUpdated = 0;
        $scope.name = '';
        $scope.secret = '';
        $scope.isValid = true;
        $scope.customer_id = 1;
        $scope.ratio = '16:9';
        $scope.isShow = false;
        $scope.ratioList = RATIO169;
        $scope.resolution = '1920X1080';
        $scope.width = '';
        $scope.height = '';

        $scope.validChange = function () {
            if ($scope.name !== '') {
                $scope.isValid = true;
            } else {
                $scope.isValid = false;
                $scope.message = ' screen name must be filled.';
                return;
            }
            if ($scope.secret !== '') {
                $scope.isValid = true;
            } else {
                $scope.isValid = false;
                $scope.message = ' screen secret must be filled.';
                return;
            }
            if ($scope.width <= 0) {
                $scope.isValid = false;
                $scope.message = ' screen width must be gt zero.';
                return;
            } else {
                $scope.isValid = true;
            }
            if ($scope.height <= 0) {
                $scope.isValid = false;
                $scope.message = ' screen height must be gt zero.';
                return;
            } else {
                $scope.isValid = true;
            }
        };
        $scope.ratioChange = function () {
            if ($scope.ratio === '16:9') {
                $scope.isShow = false;
                $scope.resolution = '1920X1080';
                $scope.ratioList = RATIO169;
            } else if ($scope.ratio === '9:16') {
                $scope.ratioList = RATIO916;
                $scope.isShow = false;
                $scope.resolution = '1080X1920';
            } else if ($scope.ratio === '4:3') {
                $scope.ratioList = RATIO43;
                $scope.isShow = false;
                $scope.resolution = '1280X1024';
            } else {
                $scope.isShow = true;
                $scope.width = '';
                $scope.height = '';
            }
        };

        $scope.clearForm = function () {
            $scope.screen_id = 0;
            $scope.name = '';
            $scope.secret = '';
            $scope.customer_id = 1;
            $scope.ratio = '16:9';
            $scope.ratioList = RATIO169;
            $scope.resolution = '1920X1080';
            $scope.width = '';
            $scope.height = '';
            $scope.isShow = false;
        };

        $scope.saveScreen = function () {
            if ($scope.ratio != "") {
                var tem = $scope.resolution.split('X');
                $scope.width = tem[0];
                $scope.height = tem[1];
            }
            $scope.validChange();
            if ($scope.isValid) {
                $http({
                    url: '/screen/screen/save',
                    method: "POST",
                    data: $.param({screen: {name: $scope.name, customer_id: $scope.customer_id, ratio: $scope.ratio, width: $scope.width, height: $scope.height, secret: $scope.secret}, screen_id: $scope.screen_id}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (data) {
                    if (data.status == 'ok') {
                        $scope.isUpdated++;
                        $('#screen').modal('toggle');
                    } else {
                        alert('Network error.');
                    }
                });
            }
        };

        $scope.activeDeleteScreen = function (screen_id) {
            $scope.screen_id = screen_id;
            $("#deleteScreen").modal('toggle');
        };

        $scope.archiveScreen = function () {
            $http({
                url: '/screen/screen/delete',
                method: "POST",
                data: $.param({screen_id: $scope.screen_id}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data) {
                if (data.status == 'ok') {
                    $scope.isUpdated++;
                    $("#deleteScreen").modal('toggle');
                } else {
                    alert('Network error.');
                }
            });
        };

        $scope.activeFullScreen = function (item) {
            $http({
                url: '/screen/preview/window',
                method: "POST",
                data: $.param({screen_id: item.screen_id}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data) {
                window.open(data.screen.url, data.screen.name, "toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=" + data.screen.width + ",height=" + data.screen.height);
            });
        };

        $scope.preview = function (spot) {
            $scope.spot_name = spot.title;
            $scope.spot_image = spot.image;
            $scope.spot_video = spot.video;
            $("#spot_preview video").attr('src', spot.video);
            $("#spot_preview").modal('toggle');
            $('#spot_preview').on('hidden.bs.modal', function () {
                $("#spot_preview video").removeAttr('src');
            });
        };

        $scope.edit = function (spot) {
            window.location.href = "/screen/spots/update/id/" + spot.sid;
        };

        $scope.delete = function (index, spot, spots) {
            $scope.spot_title = spot.title;
            $scope.delete_pos_id = spot.pid;
            $scope.index = index;
            $scope.spots = spots;
            $scope.spot_message = "Are you sure you want to delete this spot?";
            $("#deleteSpot").modal("toggle");
        };

        $scope.deleteSpot = function () {
            $http({
                url: '/screen/spots/delete',
                method: "POST",
                data: $.param({pos_id: $scope.delete_pos_id}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data) {
                if (data.status) {
                    $scope.spots.splice($scope.index, 1);
                    $("#deleteSpot").modal("toggle");
                }
            });
        };

        $scope.publish = function (spot) {
            $http({
                url: '/screen/spots/publish',
                method: "POST",
                data: $.param({pos_id: spot.pid, type: spot.pc,spot_id:spot.sid}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data) {
                if (data.status) {
                    spot.pc = data.type;
                    spot.status = data.status;
                }
            });
        };

        $scope.activeUpdateScreen = function (item) {
            $scope.name = item.name;
            $scope.ratio = item.ratio;
            if (item.ratio == '16:9') {
                $scope.ratioList = RATIO169;
                $scope.isShow = false;
                $scope.resolution = item.width + 'X' + item.height;
            } else if (item.ratio == '9:16') {
                $scope.ratioList = RATIO916;
                $scope.isShow = false;
                $scope.resolution = item.width + 'X' + item.height;
            } else if (item.ratio == '4:3') {
                $scope.ratioList = RATIO43;
                $scope.isShow = false;
                $scope.resolution = item.width + 'X' + item.height;
            } else {
                $scope.isShow = true;
                $scope.resolution = "";
                $scope.width = item.width;
                $scope.height = item.height;
            }
            $scope.customer_id = item.customer_id;
            $scope.secret = item.secret;
            $scope.screen_id = item.screen_id;
            $("#screen").modal('toggle');
        };

        $scope.showIcno = function (is_open) {
            if (is_open) {
                return 'unspread';
            } else {
                return 'spread';
            }
        };

        $scope.showPlaylist = function (item) {
            if (item.is_open) {
                item.is_open = false;
            } else {
                item.is_open = true;
            }
        };

        $scope.spotTime = function (item) {
            if (item.owner) {
                return item.time;
            } else {
                return null;
            }
        };

        $scope.command = function (screen_id, spot, cmd) {
            $http({
                url: '/screen/spots/cmd',
                method: "POST",
                data: $.param({screen_id: screen_id, spot_id: spot.sid, cmd: cmd}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data) {
                if (data.status) {
                    spot.cmd = cmd;
                }
            });
        };

        $scope.copy = function (spot) {
            $http({
                url: '/screen/spots/encrypt',
                method: "POST",
                data: $.param({spot_id: spot.sid}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data) {
                if (data.status) {
                    $scope.spot_title = "Encrypt this url as preview link";
                    $scope.copy_link = null;
                    $scope.copy_link = data.link;
                    $("#copy-link").modal('toggle');
                }
            });
        };

        $scope.$watch('isUpdated', function () {
            $http.get('/screen/screen/list').success(function (result) {
                $scope.items = result;
                $scope.isShowTable = true;
            });
        });
    });
</script>