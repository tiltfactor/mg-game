<?php
class SearchModule extends CWebModule
{
    public function init()
    {
        $this->setImport(array(
            'search.models.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }
}
