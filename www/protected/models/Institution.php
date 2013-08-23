<?php

Yii::import('application.models._base.BaseInstitution');

class Institution extends BaseInstitution
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}