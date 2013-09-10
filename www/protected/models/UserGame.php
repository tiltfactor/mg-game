<?php

Yii::import('application.models._base.BaseUserGame');

class UserGame extends BaseUserGame
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}