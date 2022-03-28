<?php

class RbmsModule extends CWebModule {

    public function init() {
        $this->defaultController = 'user';
        $this->setImport(array(
            'rbms.models.*',
            'rbms.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }

}
