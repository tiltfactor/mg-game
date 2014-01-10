<?php

$this->breadcrumbs = array(
	Yii::t('app', 'Admin')=>array('/admin'),
	Yii::t('app', 'Tags')=>array('/admin/tag'),
	$model->label(2),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tag-use-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php 

$tagDialog = $this->widget('MGTagJuiDialog');

function getInstitutionUrl($id)
{
    $command = Yii::app()->db->createCommand();
    $url = $command->select('url')->from('institution')->where('id=:id', array(':id'=>$id))->queryScalar();
    return $url;
}

// Little different from the way it's done in other pages, but it works
function generateImage($data) {
    $media = $data->media;
    $institutionUrl = getInstitutionUrl($media['institution_id']);

    $image_html = CHtml::image(MGHelper::getMediaThumb($institutionUrl, $media['mime_type'], $media['name']), $media['name'], array('height'=>60)) . " <span> " . $media['name'] . "</span>";
    $media_html = GxHtml::link($image_html, array('media/view', 'id' => GxActiveRecord::extractPkValue($data->media, true)), array('class' => 'image'));

    return $media_html;
}

echo CHtml::beginForm('','post',array('id'=>'tag-use-form'));
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'tag-use-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'cssFile' => Yii::app()->request->baseUrl . "/css/yii/gridview/styles.css",
	'pager' => array('cssFile' => Yii::app()->request->baseUrl . "/css/yii/pager.css"),
	'baseScriptUrl' => Yii::app()->request->baseUrl . "/css/yii/gridview",
	'afterAjaxUpdate' => $tagDialog->gridViewUpdate(),
	'columns' => array(
    array(
        'header' => Yii::t('app', 'Media (Filter with ID)'),
        'name' => 'media_id',
        'cssClassExpression' => '"med"',
        'type'=>'html',
        'value' => 'generateImage($data)',
        //'value'=>'GxHtml::link(CHtml::image(Yii::app()->getBaseUrl() . Yii::app()->fbvStorage->get(\'settings.app_upload_url\') . \'/thumbs/\'. GxHtml::valueEx($data->media), GxHtml::valueEx($data->media)) . " <span>" . GxHtml::valueEx($data->media) . "</span>", array(\'media/view\', \'id\' => GxActiveRecord::extractPkValue($data->media, true)))',
      ),
		array(
		    'header' => Yii::t('app', 'Tag (Filter with ID)'),
				'name' => 'tag_id',
				'type' => 'html',
				'value' => '$data->getTagToolLink()',
				),
		'weight',
		array(
      'name' => 'type',
      'filter' => TagUse::getUsedTypes()
    ),
    array(
      'header' => Yii::t('app', 'Player Name'),
      'name' => 'username',
      'type'=>'html',
      'value'=>'$data->getUserName(true)',
    ),
    array(
      'header' => Yii::t('app', 'IP Address'),
      'name' => 'ip_address',
      'type'=>'raw',
      'value'=>'long2ip($data->ip_address)',
    ),
		'created',
    array (
  'class' => 'CButtonColumn',
  'template' => '{view} {update} {reweight}',
  'buttons' => 
    
    array (
        'delete' => array('visible' => $admin ? 'true' : 'false'),
        'update' => array('visible' => $admin ? 'true' : 'false'),
    'reweight' => array (
      'label'=>'re-weight', 
      'url'=> "Yii::app()->createUrl('admin/tagUse/weight', array('id' => \$data->id))",    
      'imageUrl'=> Yii::app()->request->baseUrl . "/css/yii/gridview/scale.png",
        'visible' => $admin ? 'true' : 'false',
    )
  ),
)  ),
)); 
echo CHtml::endForm();

?>
