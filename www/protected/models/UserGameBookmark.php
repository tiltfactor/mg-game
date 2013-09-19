<?php

Yii::import('application.models._base.BaseUserGameBookmark');

class UserGameBookmark extends BaseUserGameBookmark
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}