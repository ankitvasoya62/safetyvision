<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular.min.js"></script>
<?php $this->renderPartial('../tools'); ?>

<div id="cmain" class="box" ng-app="user" ng-controller="userCtrl" ng-cloak>
    <div id="cheader" class="title">
        <span>User Information</span>
    </div>
    <div id="ccontent">
        <div class="row">
            <div class="col-xs-3" style="min-width: 500px;">
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
                            <tr>
                                <th colspan="2"><button type="button" class="btn btn-primary" ng-disabled="!create_user_form.$valid || !is_Same" ng-click="save()"><?php echo Yii::t("lang", "Submit"); ?></button></th>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    angular.module("user", []).controller("userCtrl", function($scope, $http) {
        $scope.customer_id = "<?php echo $customer['id']; ?>";
        $scope.customer_name = "<?php echo $customer['name']; ?>";

        $scope.init = function() {
            $scope.isValid = true;
            $scope.name = "";
            $scope.email = "";
            $scope.officephone = "";
            $scope.cellphone = "";
            $scope.lang = 'no';
            $scope.expires = "";
            $scope.password = "";
            $scope.repeatPassword = "";

            $("#datepicker").datepicker({
                showOn: "both",
                buttonImage: "/images/sv_calendar.png",
                buttonImageOnly: true,
                dateFormat: "D.dd.mm.yy",
                minDate: new Date()
            });
        };

        $scope.verifyPassword = function() {
            if ($scope.password === $scope.repeatPassword) {
                $scope.is_Same = true;
            } else {
                $scope.is_Same = false;
            }
        };

        $scope.init();

        $scope.save = function() {
            $http({
                url: '/rbms/user/save',
                method: "POST",
                data: $.param({user: {name: $scope.name, email: $scope.email, customer_id: $scope.customer_id, officephone: $scope.officephone, cellphone: $scope.cellphone, lang: $scope.lang, expires: $scope.expires, password: $scope.password}}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(data) {
                if (data.status) {
                    window.location.href = data.url;
                } else {
                    alert(data.msg);
                }
            });
        };
    });
</script>