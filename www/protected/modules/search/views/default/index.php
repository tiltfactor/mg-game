

<div class="search-form" style="display: block;">
    <?php $this->renderPartial('_search', array(
    'model' => $model,
    'institutions' => $institutions
)); ?>
</div><!-- search-form -->

<?php echo CHtml::beginForm('', 'post', array('id' => 'media-form'));
$tagDialog = $this->widget('MGTagJuiDialog');

// Maximum number of tags to show in the 'Top Tags' column.
$max_toptags = 15;

function generateImage($data)
{
    $media = CHtml::image(MGHelper::getMediaThumb($data->institution->url, $data->mime_type, $data->name), $data->name);
    return $media;
}

$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$model->search(true),
    'itemView'=>'_viewSearch',   // refers to the partial view named '_viewSearch'
    'sortableAttributes' => array(
        'name' => Yii::t('app', 'Name'),
    ),
    'enablePagination'=>true,
    'template'=>"{summary}\n{sorter}\n{pager}\n{items}\n{sorter}\n{pager}", //pager on top
));
echo CHtml::endForm();

?>