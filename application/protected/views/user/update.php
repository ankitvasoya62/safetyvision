<div class="box" id="ctoolbar">
    <ul id="tools-menu">
        <li class="menu-users"><a href="/user/">Users</a></li>
        <li class="menu-access"><a href="">Users and Access</a></li>
        <li class="menu-roles"><a href="">Roles</a></li> 
        <li style="float:right;" class="menu-adduser"><a id="user_new" href="/user/create">New User</a></li>
    </ul>
</div>

<div id="cmain" class="box">
    <div id="cheader" class="title">
        <span>New Users</span>
    </div>
    <div id="ccontent">
        <div class="row">
            <div class="col-xs-2">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-form',
                    'enableAjaxValidation' => false,
                ));
                ?>
                <h4>Fields with <span class="required">*</span> are required.</h4>

                <?php echo $form->errorSummary($model); ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'username'); ?>
                    <?php echo $form->textField($model, 'username', array('maxlength' => 30, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'username'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'customer_id'); ?>
                    <?php echo $form->dropDownList($model, 'customer_id', CHtml::listData(Customer::model()->findAll(), "id", "name"), array("class" => 'form-control')); ?>
                    <?php echo $form->error($model, 'customer_id'); ?>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'email'); ?>
                    <?php echo $form->textField($model, 'email', array('maxlength' => 60, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'password'); ?>
                    <?php echo $form->passwordField($model, 'password', array('maxlength' => 48, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>

                <div class="form-group">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => "bth bth-default")); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>