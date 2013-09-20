<?php

Yii::import('application.models._base.BaseUserGameBannedInstitution');

class UserGameBannedInstitution extends BaseUserGameBannedInstitution
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}