<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/rbms.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.min.css" />
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.10.2.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('/site/login'));
        }
        ?>
    </head>
    <body>
        <div id="header" class="box">
            <div id="logo"></div>
            <div id="user_info">
                <div class="user_info_top">
                    <span class="span_left"><a href="/rbms/user/profile/id/<?php echo Yii::app()->user->id; ?>"><?php echo Yii::app()->user->name; ?></a></span>
                    <span class="span_right"><?php echo Yii::t('lang', 'Currently logged in as'); ?>: <?php echo (new RoleAssign)->getRoleAssignName(Yii::app()->user->id)[0]['name'] ?></span>
                </div>
                <div class="user_info_bottom">
                    <span class="span_left">
                        <form id="changeCustomer-form" action="/site/changeCustomer" method="post">
                            <input type="hidden" name="return_url" value="<?php echo Yii::app()->request->getUrl(); ?>" />
                            <select class="form-control menu_select" name ="customer_id" onchange="submit()">
                                <?php
                                $customers = Customer::model()->getCustomerList();
                                foreach ($customers as $val) {
                                    ?>
                                    <option value="<?php echo $val['id']; ?>" <?php
                                    if ($val['id'] == Yii::app()->user->filter_customer_id) {
                                        echo "selected";
                                    }
                                    ?> ><?php echo $val['name']; ?></option>
                                            <?php
                                        }
                                        ?>
                            </select>
                        </form>
                    </span>
                    <span class="span_right">

                    </span>
                </div>
            </div>
        </div>
        <?php
        $init = array('menu.customer' => 0, 'menu.screen' => 0, 'menu.archive' => 0, 'menu.administrator' => 0
    , 'menu.administrator.roles' => 0);
        $access = AuthManage::checkAccess($init);
        ?>
        <div id="main">
            <div id="sidebar" class="box">
                <ul id="side-menu">
                    <li class="menu-header"><?php echo Yii::t('lang', 'Online Vision'); ?></li>
                    <li data_param="menu_home" class="menu-home "><a href="/">Home</a></li>
                    <?php if ($access['menu.customer']) { ?>
                        <li class="menu-customers"><?php echo CHtml::link(Yii::t('lang', 'Customer'), array('/screen/customer')); ?></li>
                    <?php } ?>
                    <?php if ($access['menu.screen']) { ?>
                        <li class="menu-ds"><?php echo CHtml::link(Yii::t('lang', 'Screen'), array('/screen/screen')); ?></li>
                    <?php } ?>
                    <?php if ($access['menu.archive']) { ?>
                        <li class="menu-archive"><?php echo CHtml::link(Yii::t('lang', 'Archive'), array('/archive/index')); ?></li>
                    <?php } ?>
                    <?php if ($access['menu.administrator']) { ?>
                        <li class="menu-user"><a href="/rbms"><?php echo Yii::t('lang', ' Administrator'); ?></a></li>
                    <?php } ?>
                    <?php if ($access['menu.administrator.roles']) { ?>
                        <li class="menu-logout"><?php echo CHtml::link(Yii::t('lang', 'Role'), array('/rbms/roles/index')); ?></li>
                    <?php } ?>
                    <li class="menu-logout"><?php echo CHtml::link(Yii::t('lang', 'Log out'), array('/site/logout')); ?></li>
                </ul>
            </div>
            <?php echo $content; ?>
        </div>
        <div id="footer" class="box"><?php echo Yii::t('lang', Yii::app()->params['copyright']); ?></div>
    </body>
</html>