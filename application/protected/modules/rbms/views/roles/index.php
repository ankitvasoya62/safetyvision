<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular.min.js"></script>
<?php $this->renderPartial('../tools'); ?>

<div id="cmain" class="box" ng-app="role" ng-controller="roleCtrl" ng-cloak>
    <div id="cheader" class="title">
        <span>User Information</span>
    </div>
    <div id="ccontent">
        <div class="row">
            <div class="col-xs-3" style="min-width: 600px;">
                <table class="table table-bordered user_info">
                    <thead>
                        <tr>
                            <th><?php echo Yii::t("lang", "Role"); ?></th>
                            <th><?php echo Yii::t("lang", "Descprition"); ?></th>
                            <th><?php echo Yii::t("lang", "Operate"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($roles)) {
                            foreach ($roles as $val) {
                                ?>
                                <tr>
                                    <th style="text-align: left;"><?php echo $val->name; ?></th>
                                    <th style="text-align: left;"><?php echo $val->desc; ?></th>
                                    <th><a href="/rbms/roles/set/id/<?php echo $val['id']; ?>"><span class="glyphicon glyphicon-cog"></span></a>&nbsp;<a ng-click="delete(<?php echo $val['id']; ?>)"><span class="glyphicon glyphicon-trash"></span></a></th>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><th colspan="3">None item</th></tr>';
                        }
                        ?>

                    </tbody>
                </table>
                <form name="create_role_form">
                    <table class="table table-bordered user_info">
                        <thead>
                            <tr>
                                <th colspan="2"><?php echo Yii::t("lang", "Create Roles"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><?php echo Yii::t("lang", "Role"); ?></th>
                                <td><input type="text" class="form-control" ng-model="role" required></td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t("lang", "Description"); ?></th>
                                <td><input type="text" class="form-control" ng-model="desc"></td>
                            </tr>
                            <tr>
                                <th colspan="2"><button type="button" class="btn btn-primary" ng-disabled="!create_role_form.$valid" ng-click="save()"><?php echo Yii::t("lang", "Submit"); ?></button></th>
                            </tr>
                        </tbody>
                    </table>
                </form>

                <div class="modal fade" id="deleteRole" tabindex="-5" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Delete role</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger" role="alert">
                                    <strong>Are you sure that delete the role?</strong>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" ng-click="done()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div><!-- Delete Role -->
                
            </div>
        </div>
    </div>
</div>
<script>
    angular.module("role", []).controller("roleCtrl", function($scope, $http) {
        $scope.save = function() {
            $http({
                url: '/rbms/roles/create',
                method: "POST",
                data: $.param({role: {name: $scope.role, desc: $scope.desc}}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(data) {
                if (data.status) {
                    window.location.href = data.url;
                } else {
                    alert(data.msg);
                }
            });
        };

        $scope.delete = function(id) {
            $scope.role_id = id;
            $("#deleteRole").modal("toggle");
        };
        
        $scope.done = function() {
            $http({
                url: '/rbms/roles/delete',
                method: "POST",
                data: $.param({role: {id: $scope.role_id}}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(data) {
                if (data.status) {
                    $("#deleteRole").modal("toggle");
                    window.location.href = data.url;
                } else {
                    alert(data.msg);
                }
            });
        };
    });
</script>