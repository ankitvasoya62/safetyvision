<?php

class ScreenModule extends CWebModule {

    public function init() {
        $this->defaultController = 'index';
        $this->setImport(array(
            'screen.models.*',
            'screen.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }

}