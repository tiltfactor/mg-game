<?php
/**
 * This is the model class for table "cron_jobs".
 *
 * The followings are the available columns in table 'cron_jobs':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $url
 * @property string $token
 * @property integer $status
 * @property string $created
 *
 * @package
 * @author     Nikolay Kondikov<nikolay.kondikov@sirma.bg>
 */
class Institution extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'institution';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, email, password, url', 'required'),
            array('name, email, url', 'unique'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('email', 'email'),
            array('password', 'required', 'on' => 'insert'),
            array('action', 'length', 'max' => 255),
            array('id, name, email, password, url, token, status, created', 'safe', 'on' => 'search')
        );
    }

    public function relations()
    {
        return array();
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Institution Name'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'url' => Yii::t('app', 'URL'),
            'token' => Yii::t('app', 'Auth. Token'),
            'status' => Yii::t('app', 'Status'),
            'created' => Yii::t('app', 'Created'),
        );
    }

    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    public function afterFind()
    {
        return parent::afterFind();
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('token', $this->token, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}

