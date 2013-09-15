<?php

Yii::import('application.models._base.BaseUserMessage');

class UserMessage extends BaseUserMessage
{
    const TYPE_NONE = 0;
    const TYPE_CHALLENGE = 1;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}