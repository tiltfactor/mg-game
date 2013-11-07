<?php

$this->breadcrumbs = array(
    Yii::t('app', 'Admin') => array('/admin'),
    $model->label(),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('media-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

    <h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label()); ?></h1>

    <p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
    </p>

<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
    <div class="search-form">
        <?php $this->renderPartial('_search', array(
            'model' => $model,
        )); ?>
    </div><!-- search-form -->

<?php echo CHtml::beginForm('', 'post', array('id' => 'media-form'));
$tagDialog = $this->widget('MGTagJuiDialog');

// Maximum number of tags to show in the 'Top Tags' column.
$max_toptags = 15;

function generateImage($data) {
    $media = CHtml::image(MGHelper::getMediaThumb($data->institution->url,$data->mime_type,$data->name),$data->name,array('height'=>60)) . " <span>" . $data->name . "</span>";
    return $media;
}

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'media-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'cssFile' => Yii::app()->request->baseUrl . "/css/yii/gridview/styles.css",
    'pager' => array('cssFile' => Yii::app()->request->baseUrl . "/css/yii/pager.css"),
    'baseScriptUrl' => Yii::app()->request->baseUrl . "/css/yii/gridview",
	'afterAjaxUpdate' => $tagDialog->gridViewUpdate(),
    'selectableRows' => 2,
    'columns' => array(
        array(
            'name' => 'name',
            'cssClassExpression' => '"media"',
            'type' => 'html',
            'value' => 'generateImage($data)',
        ),
        'tag_count',
        array(
            'cssClassExpression' => "'tags'",
            'header' => Yii::t('app', "Top $max_toptags Tags"),
            'type' => 'html',
            'value' => '$data->getTopTags(' . $max_toptags . ')',
        ),
        array(
            'cssClassExpression' => "'tags'",
            'header' => Yii::t('app', 'Collections'),
            'type' => 'html',
            'value' => '$data->listCollections()',
        ),
        //'size',
		'batch_id',
        'last_access',
        //'created',
        //'modified',
        array(
            'cssClassExpression' => "'tags'",
            'header' => Yii::t('app', 'Institution'),
            'type' => 'html',
            'value' => '$data->institution->name',
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
