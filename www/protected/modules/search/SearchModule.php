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

    public static function getGameStats($stat)
    {
        $command = Yii::app()->db->createCommand();
        $result = NULL;

        switch ($stat) {
            case "no_of_games_played":
                $result = $command->select('sum(number_played)')->from('game')->queryScalar();
            case "no_of_tags_submitted":
                $result = $command->select('count(tag)')->from('tag')->queryScalar();
        }

        return number_format($result);
    }
}
