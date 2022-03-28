<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular.min.js"></script>
<?php $this->renderPartial('../tools'); ?>

<div id="cmain" class="box">
    <div id="cheader" class="title">
        <span>User Information</span>
    </div>
    <div id="ccontent">
        <div class="row">
            <div class="col-xs-3" style="min-width: 500px;">
                <table class="table table-bordered user_info" ng-app="role" ng-controller="roleCtrl" ng-cloak>
                    <tbody>
                        <tr>
                            <th>Role Name</th>
                            <td><input type="text" ng-model="name" class="form-control" ng-blur="resetRole('name')"></td>
                        </tr>
                        <tr>
                            <th>Role Description</th>
                            <td><input type="text" ng-model="desc" class="form-control" ng-blur="resetRole('desc')"></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table user_role_assign menu-roles">
                    <thead>
                        <tr>
                            <th colspan="3">Menu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:20px;"><a class="<?php
                                        if ( RoleOperate::checkRole($model->id, 1)) {
                                echo 'checked_on';
                                } else {
                                echo 'checked_off';
                                }
                                ?>" data_id="1"></a></td>
                            <td>Menu: Customer</td>
                            <td style="width:20px;" ></td>
                        </tr>
                        <tr>
                            <td style="width:20px;"><a class=" <?php
                                if (RoleOperate::checkRole($model->id, 2)) {
                                echo 'checked_on';
                                        } else { echo 'checked_off';
                                }
                                ?>" data_id="2"></a></td>
                            <td>Menu: Screen</td>
                            <td style="width:20px;"></td>
                        </tr>
                        <tr>
                            <td style="width:20px;"><a class=" <?php
                                if (RoleOperate::checkRole($model->id, 3)) {
                                echo 'checked_on';
                                } else {
                                echo 'checked_off';
                                }
                                ?>" data_id="3"></a></td>
                                    <td>Menu: Archive</td>
                                    <td style="width:20px;"></td>
                                </tr>
                                <tr>
                                    <td style="width:20px;"><a class=" <?php
                                if (RoleOperate::checkRole($model->id, 4)) {
                                echo 'checked_on';
                                                 } else {
                                echo 'checked_off';
                                }
                                ?>" data_id="4"></a></td>
                            <td>Menu: Administrator</td>
                            <td style="width:20px;"></td>
                        </tr>
                        <tr>
                            <td style="width:20px;"></td>
                            <td><a class=" <?php
                                if (RoleOperate::checkRole($model->id, 5)) {
                                echo 'checked_on';
                                } else {
                                echo 'checked_off';
                                }
                                ?>" data_id="5"></a> &nbsp;Menu: Users</td>
                            <td style="width:20px;"></td>
                        </tr>
                        <tr>
                            <td style="width:20px;"></td>
                            <td><a class="<?php
                                if (RoleOperate::checkRole($model->id, 6)) {
                                echo 'checked_on';
                                        } else {
                                                 echo 'checked_off';
                                }
                                ?>" data_id="6"></a> &nbsp;Menu: User and Access</td>
                            <td style="width:20px;"></td>
                        </tr>
                        <tr>
                            <td style="width:20px;"></td>
                            <td><a class=" <?php
                                if (RoleOperate::checkRole($model->id, 7)) {
                                echo 'checked_on';
                                } else {
                                echo 'checked_off';
                                }
                                                
                                                ?> " data_id="7"></a> &nbsp;Menu: Roles</td>
                            <td style="width:20px;"></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered user_role_assign">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th style="width:20px;">1</th>
                            <td>User: Create</td>
                            <th style="width:60px;"><a class="sw   <?php
                                if (RoleOperate::checkRole($model->id, 15)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                        }
                                                 
                                                ?>" data_id="15"></a></th>
                        </tr>
                        <tr>
                            <th style="width:20px;">2</th>
                            <td>User: Edit</td>
                            <th style="width:60px;"><a class="sw <?php
                                if (RoleOperate::checkRole($model->id, 16)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                }
                                ?>" data_id="16"></a></th>
                        </tr>
                        <tr>
                            <th style="width:20px;">3</th>
                            <td>User: Delete</td>
                            <th style="width:60px;"><a class="sw  <?php
                                if (RoleOperate::checkRole($model->id, 17)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                        }
                                                 
                                ?>" data_id="17"></a></th>
                        </tr>
                        <tr>
                            <th style="width:20px;">4</th>
                            <td>Role: Create</td>
                            <th style="width:60px;"><a class="sw <?php
                                if (RoleOperate::checkRole($model->id, 18)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                }
                                ?>" data_id="18"></a></th>
                        </tr>
                        <tr>
                            <th style="width:20px;">5</th>
                            <td>Role: Edit</td>
                            <th style="width:60px;"><a class="sw <?php
                                if (RoleOperate::checkRole($model->id, 19)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                        }
                                                 
                                ?>" data_id="19"></a></th>
                        </tr>
                        <tr>
                            <th style="width:20px;">6</th>
                            <td>Role: Delete</td>
                            <th style="width:60px;"><a class="sw <?php
                                        if (RoleOperate::checkRole( $model->id, 20)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                }
                                ?>" data_id="20"></a></th>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered user_role_assign">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer Name</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th style="width:20px;">1</th>
                                            <td>Customer: Create</td>
                                            <th style="width:60px;"><a class="sw   <?php
                                if (RoleOperate::checkRole($model->id, 8)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                }
                                ?>" data_id="8"></a></th>
                        </tr>
                        <tr>
                            <th style="width:20px;">2</th>
                            <td>Customer: Edit</td>
                            <th style="width:60px;"><a class="sw  <?php
                                if (RoleOperate::checkRole($model->id, 9)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                }
                                ?>" data_id="9"></a></th>
                                        </tr>
                                        <tr>
                                            <th style="width:20px;">3</th>
                                            <td>Customer: Delete</td>
                                            <th style="width:60px;"><a class="sw  <?php
                                if (RoleOperate::checkRole($model->id, 10)) {
                                                 echo 'on';
                                } else {
                                echo 'off';
                                }
                                ?>" data_id="10"></a></th>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered user_role_assign">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Screen Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th style="width:20px;">1</th>
                            <td>Screen: Create</td>
                            <th style="width:60px;"><a class="sw  <?php
                                if (RoleOperate::checkRole($model->id, 11)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                }
                                ?>" data_id="11"></a></th>
                        </tr>
                        <tr>
                            <th style="width:20px;">2</th>
                            <td>Screen: Edit</td>
                            <th style="width:60px;"><a class="sw <?php
                                if (RoleOperate::checkRole($model->id, 12)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                }
                                ?>" data_id="12"></a></th>
                        </tr>
                        <tr>
                            <th style="width:20px;">3</th>
                            <td>Screen: Delete</td>
                            <th style="width:60px;"><a class="sw  <?php
                                if (RoleOperate::checkRole($model->id, 13)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                }
                                         
                                        ?>" data_id="13"></a></th>
                        </tr>
                        <tr>
                            <th style="width:20px;">4</th>
                            <td>Screen: Send Command</td>
                            <th style="width:60px;"><a class="sw <?php
                                if (RoleOperate::checkRole($model->id, 14)) {
                                echo 'on';
                                } else {
                                echo 'off';
                                         }
                                ?>" data_id="14"></a></th>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered user_role_assign">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Spot Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th style="width:20px;">1</th>
                            <td>Spot: Create</td>
                            <th style="width:60px;"><a class="sw  <?php
                                if (RoleOperate::checkRole($model->id, 21)) {
                                    echo 'on';
                                } else {
                                    echo 'off';
                                }
                                ?>" data_id="21"></a></th>
                        </tr>
                        <tr>
                            <th style="width:20px;">2</th>
                            <td>Spot: Edit</td>
                            <th style="width:60px;"><a class="sw <?php
                                if (RoleOperate::checkRole($model->id, 22)) {
                                    echo 'on';
                                } else {
                                    echo 'off';
                                }
                                ?>" data_id="22"></a></th>
                        </tr>
                        <tr>
                            <th style="width:20px;">3</th>
                            <td>Spot: Delete</td>
                            <th style="width:60px;"><a class="sw <?php
                                                       if (RoleOperate::checkRole($model->id, 23)) {
                                                           echo 'on';
                                                       } else {
                                                           echo 'off';
                                                       }
                                                       ?>" data_id="23"></a></th>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    angular.module("role", []).controller("roleCtrl", function ($scope, $http) {
        $scope.role_id = "<?php echo Yii::app()->request->getParam('id', null); ?>";
        $scope.name = "<?php echo $model->name; ?>";
        $scope.desc = "<?php echo $model->desc; ?>";

        $scope.resetRole = function (type) {
            if (type == 'name') {
                $http({
                    url: '/rbms/roles/update',
                    method: "POST",
                    data: $.param({role: {id: $scope.role_id, type: "name", name: $scope.name}}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (data) {
                    if (data.status) {
                        return;
                    }
                });
            }
            else if (type == 'desc') {
                $http({
                    url: '/rbms/roles/update',
                    method: "POST",
                    data: $.param({role: {id: $scope.role_id, type: "desc", desc: $scope.desc}}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (data) {
                    if (data.status) {
                        return;
                    }
                });
            }
        };
    });

    $(document).ready(function () {
        $(".menu-roles td a").click(function () {
            var me = $(this);
            if ($(this).hasClass("checked_on")) {
                $.post("/rbms/roles/assign", $.param({role_id: "<?php echo Yii::app()->request->getParam('id', null); ?>", operate_id: me.attr("data_id"), is_on: 0}), function (data) {
                    if (data.status) {
                        me.removeClass("checked_on").addClass("checked_off");
                    }
                }, "json");
            } else {
                $.post("/rbms/roles/assign", $.param({role_id: "<?php echo Yii::app()->request->getParam('id', null); ?>", operate_id: me.attr("data_id"), is_on: 1}), function (data) {
                    if (data.status) {
                        me.removeClass("checked_off").addClass("checked_on");
                    }
                }, "json");
            }
        });

        $(".user_role_assign th a.sw").click(function () {
            var me = $(this);
            if ($(this).hasClass("on")) {
                $.post("/rbms/roles/assign", $.param({role_id: "<?php echo Yii::app()->request->getParam('id', null); ?>", operate_id: me.attr("data_id"), is_on: 0}), function (data) {
                    if (data.status) {
                        me.removeClass("on").addClass("off");
                    }
                }, "json");

            } else {
                $.post("/rbms/roles/assign", $.param({role_id: "<?php echo Yii::app()->request->getParam('id', null); ?>", operate_id: me.attr("data_id"), is_on: 1}), function (data) {
                    if (data.status) {
                        me.removeClass("off").addClass("on");
                    }
                }, "json");
            }
        });
    });
</script>