<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css"/>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <header>
            <div id="logo"><h2>Safetyvision</h2></div>
        </header>
        <section style="height: 9em;"></section>
        <section id="wrap">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'login-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                ));
                ?>
                <div class="form-group has-success">
                    <?php echo $form->labelEx($model, 'username'); ?>
                    <?php echo $form->emailField($model, 'username', array("class" => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'password'); ?>
                    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
                <div class="form-group" style="margin-top:10px;">
                    <span>Forgot password?</span>
                    <?php echo CHtml::submitButton('Login', array('class' => 'btn btn-default')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </section>
        <section class="blank"></section>
        <footer>
            <p>&copy; <?php echo date("Y", time()); ?> Online Onlinelogistics as - All rights reserved - Version: <?php echo date('d.m.Y', time()); ?></p>
        </footer>
    </body>
</html>