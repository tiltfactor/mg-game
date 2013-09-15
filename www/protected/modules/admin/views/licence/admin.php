<?php

$this->breadcrumbs = array(
    Yii::t('app', 'Admin') => array('/admin'),
    $model->label(2),
);
$this->menu = array( /*array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),*/
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('licence-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

    <h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

    <p>
        You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of
        each of your search values to specify how the comparison should be done.
    </p>

<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
    <div class="search-form">
        <?php $this->renderPartial('_search', array(
            'model' => $model,
        )); ?>
    </div><!-- search-form -->

<?php echo CHtml::beginForm('', 'post', array('id' => 'licence-form'));
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'licence-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'cssFile' => Yii::app()->request->baseUrl . "/css/yii/gridview/styles.css",
    'pager' => array('cssFile' => Yii::app()->request->baseUrl . "/css/yii/pager.css"),
    'baseScriptUrl' => Yii::app()->request->baseUrl . "/css/yii/gridview",
    'selectableRows' => 2,
    'columns' => array(
        'name',
        'description',
        'created',
        'modified',
        array(
            'header' => Yii::t('app', 'Institution'),
            'type' => 'raw',
            'value' => '$data->institution',
        ),
        array(
            'class' => 'CButtonColumn',
            'buttons' =>
            array(
                'delete' => array('visible' => 'false'),
                'update' => array('visible' => 'false'),
            ),
        )),
));
echo CHtml::endForm();

?>