<?php
class SearchModule extends CWebModule
{
    private static $_assetsUrl;
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

    public static function getAssetsUrl()
    {
        if (self::$_assetsUrl === null) {
            self::$_assetsUrl = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias('application.modules.search.assets'), false, -1, YII_DEBUG);
        }
        return self::$_assetsUrl;
    }
}
