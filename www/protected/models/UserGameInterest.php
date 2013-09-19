<?php

Yii::import('application.models._base.BaseUserGameInterest');

class UserGameInterest extends BaseUserGameInterest
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}