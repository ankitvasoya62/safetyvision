<link  href="/css/jquery-ui.min.css" rel="stylesheet">
<script src="/js/jquery-ui.min.js"></script>
<style>
    #customer .modal-dialog{width: 500px;}
    #customer tr th{text-align: right; font-weight: bold; height: 50px; line-height: 50px;font-size: 14px; padding: 0 8px;}
    #customer table tr:nth-child(1) ~ tr td input{display: inline-block;width: 260px;}
    #ccontent tbody tr:hover{background:#e1f579;}
</style>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular.min.js"></script>
<?php
$init = array('customers.create' => 0, 'customers.edit' => 0, 'customers.delete' => 0);
$access = AuthManage::checkAccess($init);
?>
<div ng-app="customer" ng-controller="customerCtrl">
    <div id="ctoolbar" class="box">
        <div class="fl text" style="max-height:30px;"></div>
        <ul id="tool-menu" class="tr">
            <?php if($access['customers.create']){ ?>
            <li class="menu-screen-new"><a href="javascript:void(0);" ng-click="addCustomer()"><?php echo Yii::t('lang', 'New Customer'); ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div id="cmain" class="box">
        <div id="cheader" class="title" style="padding:0 0;">
            <span><?php echo Yii::t('lang', 'Customers'); ?> </span> <img src="/images/user.png" alt="" border="0" width="14" height="14" />
        </div>
        <div id="ccontent" style="background: #ffffff;min-width: 1000px;">
            <div ng-hide="isShowTable"><img src="/images/loading.gif"></div>
            <table class="table table-bordered" ng-show="isShowTable" ng-cloak>
                <thead class="parent_thead">
                    <tr>
                        <th style="width:50px; text-align: center;">ID</th>
                        <th>Customer</th>
                        <th>Start Date</th>
                        <th>Stop Date</th>
                        <th>Users</th>
                        <th style="width:80px;text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="customer in customers">
                        <td style="text-align: center;">{{customer.id}}</td>
                        <td>{{customer.name}}</td>
                        <td>{{customer.start_date_p}}</td>
                        <td>{{customer.stop_date_p}}</td>
                        <td>{{customer.user}}</td>
                        <td style="width:80px;text-align: center;">
                            <?php if($access['customers.edit']){ ?>
                            <a class="edit" ng-click="updateCustomer(customer)"></a>
                            <?php } ?>
                            <?php if($access['customers.delete']){ ?>
                            <a class="delete" ng-click="deleteCustomer(customer.id)"></a>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="customer" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{{customer_title}}</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th><?php echo Yii::t('lang', 'Customer name'); ?>:</th>
                                <td><input type="text" class="form-control" required="required" ng-model="name" ng-blur="vertfyForm()"/></td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t('lang', 'From date'); ?>:</th>
                                <td><input type="text" class="form-control" required="required" id="spot-start-date" ng-model="startdate"/></td>
                            </tr>
                            <tr>
                                <th><?php echo Yii::t('lang', 'To date and including'); ?>:</th>
                                <td><input type="text" class="form-control" required="required" id="spot-stop-date" ng-model="stopdate" /></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="saveCustomer()" ng-disabled="isVerified">Save</button>
                    </div>
                </div>
            </div>
        </div><!-- Customer Modal -->

        <div class="modal fade" id="delete-customer" tabindex="-2" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delete Customer</h4>
                    </div>
                    <div class="modal-body">
                         <div class="alert alert-danger" role="alert">
                            <strong>Are you sure that delete this customer, if you so this, those users are inside it will be deleted?</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" ng-click="delete()">Delete</button>
                    </div>
                </div>
            </div>
        </div><!-- Delete Customer Modal -->

    </div>
</div>
<script type="text/javascript">
    angular.module('customer', [])
            .controller('customerCtrl', function($scope, $http) {
                $scope.isUpdated = 0;
                $scope.isShowTable = false;

                $scope.addCustomer = function() {
                    $scope.customer_title = 'Add Customer';
                    $scope.customer_id = null;
                    $scope.name = null;
                    $scope.isVerified = true;
                    $scope.startdate = null;
                    $scope.stopdate = null;
                    $scope.startdate = "<?php echo date("D.d.m.Y"); ?>";
                    $scope.setDate();
                    $("#customer").modal('toggle');
                };

                $scope.vertfyForm = function() {
                    if (!$scope.name) {
                        $scope.isVerified = true;
                    } else if (!$scope.startdate) {
                        $scope.isVerified = true;
                    } else {
                        $scope.isVerified = false;
                    }
                };

                $scope.setDate = function() {
                    $("#spot-start-date").datepicker({
                        showOn: "both",
                        buttonText: "Date",
                        buttonImage: "/images/calendar.png",
                        buttonImageOnly: true,
                        dateFormat: "D.dd.mm.yy",
                        minDate: new Date(),
                        onClose: function(selectedDate) {
                            $("#spot-stop-date").datepicker("option", "minDate", selectedDate);
                            $scope.startdate = selectedDate;
                        }
                    });

                    $("#spot-stop-date").datepicker({
                        showOn: "both",
                        buttonText: "Date",
                        buttonImage: "/images/calendar.png",
                        buttonImageOnly: true,
                        dateFormat: "D.dd.mm.yy",
                        minDate: new Date(),
                        onClose: function(selectedDate) {
                            $("#spot-start-date").datepicker("option", "maxDate", selectedDate);
                            $scope.stoptdate = selectedDate;
                        }
                    });
                };

                $scope.setDateUpdated = function(min) {
                    $("#spot-start-date").datepicker({
                        showOn: "both",
                        buttonText: "Date",
                        buttonImage: "/images/calendar.png",
                        buttonImageOnly: true,
                        dateFormat: "D.dd.mm.yy",
                        onClose: function(selectedDate) {
                            $("#spot-stop-date").datepicker("option", "minDate", selectedDate);
                            $scope.startdate = selectedDate;
                        }
                    });

                    $("#spot-stop-date").datepicker({
                        showOn: "both",
                        buttonText: "Date",
                        buttonImage: "/images/calendar.png",
                        buttonImageOnly: true,
                        dateFormat: "D.dd.mm.yy",
                        minDate: min,
                        onClose: function(selectedDate) {
                            $("#spot-start-date").datepicker("option", "maxDate", selectedDate);
                            $scope.stoptdate = selectedDate;
                        }
                    });
                };

                $scope.saveCustomer = function() {
                    $http({
                        url: '/screen/customer/save',
                        method: "POST",
                        data: $.param({customer: {customer_id: $scope.customer_id, name: $scope.name, startdate: $scope.startdate, stopdate: $scope.stopdate}}),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function(data) {
                        if (data.status) {
                            $scope.isUpdated++;
                            $('#customer').modal('toggle');
                        }
                    });
                };

                $scope.updateCustomer = function(customer) {
                    $scope.isVerified = false;
                    $scope.customer_title = 'Edit Customer';
                    $scope.customer_id = customer.id;
                    $scope.name = customer.name;
                    $scope.startdate = customer.start_date_p;
                    $scope.stopdate = customer.stop_date_p;
                    $scope.setDateUpdated(customer.start_date_p);
                    $("#customer").modal('toggle');
                };

                $scope.deleteCustomer = function(id) {
                    $scope.delete_customer_id = id;
                    $("#delete-customer").modal('toggle');
                };

                $scope.delete = function() {
                    $http({
                        url: '/screen/customer/delete',
                        method: "POST",
                        data: $.param({customer_id: $scope.delete_customer_id}),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function(data) {
                        if (data.status) {
                            $scope.isUpdated++;
                            $("#delete-customer").modal('toggle');
                        }
                    });
                };

                $scope.$watch('isUpdated', function() {
                    $http({
                        url: '/screen/customer/list',
                        method: "POST",
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function(data) {
                        $scope.isShowTable = true;
                        $scope.customers = data;
                    });
                });
            });
</script>