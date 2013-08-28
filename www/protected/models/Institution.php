<?php

Yii::import('application.models._base.BaseInstitution');

class Institution extends BaseInstitution
{
    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'Status' => array(
                self::STATUS_NOACTIVE => 'Not active',
                self::STATUS_ACTIVE => 'Active',
                self::STATUS_BANNED => 'Banned',
            )
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public function canDelete()
    {
        return false;
    }

    public function canCreate()
    {
        return false;
    }
}