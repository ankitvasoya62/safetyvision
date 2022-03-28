<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular.min.js"></script>
<?php $this->renderPartial('../tools'); ?>

<div id="cmain" class="box" ng-app="user" ng-controller="userCtrl" ng-cloak>
    <div id="cheader" class="title">
        <span>User Information</span>
    </div>
    <div id="ccontent">
        <div class="row">
            <div class="col-xs-3" style="min-width: 580px;">
                <form name="create_user_form">
                    <table class="table table-bordered user_info">
                        <thead>
                            <tr>
                                <th colspan="2">User Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><?php echo Yii::t("lang", "Name"); ?></th>
                                <td><input type="text" class="form-control" ng-model="name"></td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t("lang", "E-mail"); ?></th>
                                <td><input type="email" name="email" class="form-control" ng-model="email" required ng-blur="verifyForm()"><span ng-class="{is_checked: create_user_form.email.$valid, is_unchecked:!create_user_form.email.$valid}"></span></td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t("lang", "Customer"); ?></th>
                                <td><span class="user_info_customer" ng-model="customer_id">{{customer_name}}</span></td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t("lang", "Office Phone"); ?></th>
                                <td><input type="text" class="form-control" ng-model="officephone"></td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t("lang", "Cell Phone"); ?></th>
                                <td><input type="text" class="form-control" ng-model="cellphone"></td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t("lang", "Language"); ?></th>
                                <td>
                                    <select class="form-control" ng-model="lang">
                                        <option value="no"><?php echo Yii::t("lang", "Norway"); ?></option>
                                        <option value="en"><?php echo Yii::t("lang", "English"); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t("lang", "Expiry Date"); ?></th>
                                <td><input type="text" class="form-control" id="datepicker" ng-model="expires"> </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered user_info">
                        <thead>
                            <tr>
                                <th colspan="2"><?php echo Yii::t("lang", "Set Password"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><?php echo Yii::t("lang", "Password"); ?></th>
                                <td><input type="password" name="password" class="form-control" ng-model="password" required><span ng-class="{is_checked:create_user_form.password.$valid,is_unchecked:!create_user_form.password.$valid}"></span></td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t("lang", "Confirm Password"); ?></th>
                                <td><input type="password" class="form-control" ng-model="repeatPassword" ng-required="is_Same" ng-blur="verifyPassword()"><span ng-class="{is_checked:is_Same,is_unchecked:!is_Same}"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>


            <div class="col-xs-3" style="min-width: 500px;">
                <table class="table table-bordered user_info">
                    <thead>
                        <tr>
                            <th><?php echo Yii::t("lang", "Time"); ?></th>
                            <th><?php echo Yii::t("lang", "Attempt successful"); ?></th>
                            <th><?php echo Yii::t("lang", "IP"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($logs)) {
                            foreach ($logs as $val) {
                                ?>
                                <tr>
                                    <th><?php echo date('d.m.Y H:i:s', $val['time']); ?></th>
                                    <th><span class="<?php
                                        if ($val['success']) {
                                            echo "is_checked";
                                        } else {
                                            echo "is_unchecked";
                                        }
                                        ?>"></span></th>
                                    <th><?php echo $val['ip']; ?></th>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="3">None Item</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="row">
            <div class="col-xs-3" style="min-width: 580px;">
                <table class="table table-bordered user_info user_role">
                    <thead>
                        <tr>
                            <th style="width:152px;"><?php echo Yii::t("lang", "Role"); ?></th>
                            <th style="width:152px;"><?php echo Yii::t("lang", "From Date"); ?></th>
                            <th style="width:152px;"><?php echo Yii::t("lang", "To Date"); ?></th>
                            <th style="width:88px;"><a class="role_add" ng-click="addRoleAssgin()"></a></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in roles_user">
                            <td>
                                <select class="form-control" ng-model="item.id">
                                    <option ng-repeat="role in roles" ng-value="role.id" ng-selected="item.id == role.id">{{role.name}}</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control timer" ng-model="item.stime_text" ng-value="item.stime_text" ng-mouseover="timer($index)">
                            </td>
                            <td>
                                <input type="text" class="form-control timer" ng-model="item.etime_text" ng-value="item.etime_text" ng-mouseover="timer($index)">
                            </td>
                            <td>
                                <a class="role_del" ng-click="role_del($index)"></a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered user_info user_role">
                    <tbody>
                        <tr>
                            <th colspan="4"><button type="button" class="btn btn-primary" ng-disabled="!create_user_form.$valid || !is_Same" ng-click="save()"><?php echo Yii::t("lang", "Submit"); ?></button></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3" style="min-width: 580px;">
                <table class="table table-bordered user_screen">
                    <thead>
                        <tr>
                            <th style="width: 85%; text-align: left;"><?php echo Yii::t("lang", "Screes"); ?></th>
                            <th style="width: 15%;"><a ng-click="checkScreen('all','', 1)"><span class="glyphicon glyphicon-plus"></span></a> <a ng-click="checkScreen('none','none',-1)"><span class="glyphicon glyphicon-minus"></span></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="2" style="padding:0 1em;">
                                <table class="user_screen">
                                    <tr ng-repeat="screen in screens">
                                        <th style="width: 25px;"><input type="checkbox" name="screen" ng-checked="screen.is_on" ng-click="checkScreen('one',screen,$index)"></th>
                                        <th>{{screen.name}}</th>
                                        <th style="width: 30px;"><span ng-class = "{loading: done || $index === index}"></span></th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    angular.module("user", []).controller("userCtrl", function($scope, $http) {
        $scope.isUpdated = 0;
        $scope.isScreen = 0;
        $scope.isTimer = 0;
        $scope.type = "";
        $scope.roles = {};
        $scope.roles_user = [];
        $scope.is_Same = true;
        $scope.done = false;
        $scope.index = -1;
        $scope.customer_id ="<?php echo $customer['id']; ?>" ;
        $scope.customer_name ="<?php echo $customer['name']; ?>" ;

        $scope.init = function() {
            $scope.isValid = true;
            $scope.id = "<?php echo $model->id; ?>";
            $scope.name = "<?php echo $model->name; ?>";
            $scope.email = "<?php echo $model->email; ?>";
            $scope.officephone = "<?php echo $model->officephone; ?>";
            $scope.cellphone = "<?php echo $model->cellphone; ?>";
            $scope.lang = '<?php echo $model->lang; ?>';
            $scope.expires = "<?php echo $model->expires_text; ?>";
            $scope.password = "<?php echo $model->origin_password; ?>";
            $scope.repeatPassword = "<?php echo $model->origin_password; ?>";

            $("#datepicker").datepicker({
                showOn: "both",
                buttonImage: "/images/sv_calendar.png",
                buttonImageOnly: true,
                dateFormat: "D.dd.mm.yy",
                minDate: new Date()
            });
        };

        $scope.timer = function(index) {
            $scope.isTimer++;
        };

        $scope.verifyForm = function() {

        };

        $scope.role_del = function(index) {
            if ($scope.roles_user.length > 1) {
                $scope.roles_user.splice(index, 1);
            }
        };

        $scope.verifyPassword = function() {
            if ($scope.password === $scope.repeatPassword) {
                $scope.is_Same = true;
            } else {
                $scope.is_Same = false;
            }
        };

        $scope.save = function() {
            $http({
                url: '/rbms/user/save',
                method: "POST",
                data: $.param({user: {id: $scope.id, name: $scope.name, email: $scope.email, customer_id: $scope.customer_id,
                        officephone: $scope.officephone, cellphone: $scope.cellphone, lang: $scope.lang,
                        expires: $scope.expires, password: $scope.password, role: $scope.roles_user}}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(data) {
                if (data.status) {
                    window.location.href = data.url;
                } else {
                    alert(data.msg);
                }
            });
        };

        $scope.init();

        $scope.addRoleAssgin = function() {
            $scope.roles_user.push({id: 1, stime_text: "", etime_text: ""});
            $scope.isTimer++;
        };
        
        
        $scope.checkScreen = function(type,item,index){
            if(type === 'all'){
                $scope.done = true;
                $http({
                    url: '/rbms/user/setScreens',
                    method: "POST",
                    data: $.param({type:'all',user_id:"<?php echo Yii::app()->request->getParam('id', null); ?>",screens:$scope.screens}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function(data) {
                    if (data.status) {
                        $scope.isScreen++;
                    } else {
                        alert(data.msg);
                    }
                });
            }else if(type === 'none'){
                 $scope.done = true;
                 $http({
                    url: '/rbms/user/setScreens',
                    method: "POST",
                    data: $.param({type:'none',user_id:"<?php echo Yii::app()->request->getParam('id', null); ?>"}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function(data) {
                    if (data.status) {
                        $scope.isScreen++;
                    } else {
                        alert(data.msg);
                    }
                });
            }else if(type === 'one'){
                 $scope.index = index;
                 $http({
                    url: '/rbms/user/setScreens',
                    method: "POST",
                    data: $.param({type:'one',user_id:"<?php echo Yii::app()->request->getParam('id', null); ?>",screens:item}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function(data) {
                    if (data.status) {
                        $scope.isScreen++;
                    } else {
                        alert(data.msg);
                    }
                });
            }
        };
        
        
        $scope.$watch('isUpdated', function() {
            $http({
                url: '/rbms/roles/dropdown',
                method: "POST",
                data: $.param({id: "<?php echo Yii::app()->request->getParam('id', null); ?>"}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(data) {
                $scope.roles = data.role;
                $scope.roles_user = data.roleassign;
            });
        });
        
        $scope.$watch('isScreen', function() {
            $http({
                url: '/rbms/user/screens',
                method: "POST",
                data: $.param({id: "<?php echo Yii::app()->request->getParam('id', null); ?>"}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(data) {
                if (data.status) {
                    $scope.screens = data.screens;
                    $scope.done = false;
                    $scope.index = -2;
                }
            });
        });
        
        
        $scope.$watch('isTimer', function() {
            if ($scope.roles_user.length > 0) {
                $(".timer").datepicker({
                    dateFormat: "D.dd.mm.yy",
                    minDate: new Date()
                });
            }
        });
    });
</script>