<?php

/**
 * This is the model base class for the table "image".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Image".
 *
 * Columns in table "image" available as properties of the model,
 * followed by relations of table "image" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 * @property integer $size
 * @property string $mime_type
 * @property string $batch_id
 * @property string $last_access
 * @property integer $locked
 * @property string $created
 * @property string $modified
 *
 * @property ImageSet[] $imageSets
 * @property TagUse[] $tagUses
 */
abstract class BaseImage extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'image';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Image|Images', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, size, mime_type, created, modified', 'required'),
			array('size, locked', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>254),
			array('mime_type, batch_id', 'length', 'max'=>45),
			array('last_access', 'safe'),
			array('batch_id, last_access, locked', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, size, mime_type, batch_id, last_access, locked, created, modified', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'imageSets' => array(self::MANY_MANY, 'ImageSet', 'image_set_to_image(image_id, image_set_id)'),
			'tagUses' => array(self::HAS_MANY, 'TagUse', 'image_id'),
		);
	}

	public function pivotModels() {
		return array(
			'imageSets' => 'ImageSetToImage',
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'size' => Yii::t('app', 'Size'),
			'mime_type' => Yii::t('app', 'Mime Type'),
			'batch_id' => Yii::t('app', 'Batch'),
			'last_access' => Yii::t('app', 'Last Access'),
			'locked' => Yii::t('app', 'Locked'),
			'created' => Yii::t('app', 'Created'),
			'modified' => Yii::t('app', 'Modified'),
			'imageSets' => null,
			'tagUses' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('size', $this->size);
		$criteria->compare('mime_type', $this->mime_type, true);
		$criteria->compare('batch_id', $this->batch_id, true);
		$criteria->compare('last_access', $this->last_access, true);
		$criteria->compare('locked', $this->locked);
		$criteria->compare('created', $this->created, true);
		$criteria->compare('modified', $this->modified, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination'=>array(
        'pageSize'=>Yii::app()->fbvStorage->get("settings.pagination_size"),
      ),
		));
	}
}