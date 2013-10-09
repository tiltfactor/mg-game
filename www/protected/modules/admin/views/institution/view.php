<?php

$this->breadcrumbs = array(
    Yii::t('app', 'Admin') => array('/admin'),
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create'), 'visible' => $model->canCreate()),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(),
        'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?'),
        'visible' => $model->canDelete()),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'cssFile' => Yii::app()->request->baseUrl . "/css/yii/detailview/styles.css",
    'attributes' => array(
        'id',
        'name',
        array(
            'name' => 'status',
            'value' => Institution::itemAlias("UserStatus",$model->status),
        ),
        'url',
        'token',
        'ip',
        array(
            'name' => 'status',
            'value' => Institution::itemAlias("Status", $model->status),
        ),
        'created',
    ),
)); ?>

