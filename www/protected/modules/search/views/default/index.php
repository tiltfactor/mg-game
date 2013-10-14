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
function generateImageURL ($data)
{
    $url = MGHelper::getMediaThumb($data->institution->url, $data->mime_type, $data->name);
    return $url;
}

function totalItemsFound($provider)
{
    $iterator = new CDataProviderIterator($provider);
    $i = 0;
    foreach($iterator as $tmp) {
        $i++;
    }
    return $i;
}



echo '


    <div class="main_content box">';


$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$model->search(true),
    'itemView'=>'_viewSearch',   // refers to the partial view named '_viewSearch'
    'sortableAttributes' => array(
        'name' => Yii::t('app', 'Name'),
    ),
    'ajaxUpdate'=>false,
    'enablePagination'=>true,
    'template'=>"{summary}\n{sorter}\n{pager}\n{items}\n{sorter}\n{pager}", //pager on top
    'summaryText'=>" ",

));

echo '</div></div>';
echo CHtml::endForm();

echo "<div id=\"totalItemsFound\">";
$itemsFound =  totalItemsFound($model->search(true));
if($itemsFound != 0) echo  'Your search ' . "<div id=\"searchedValue\"> </div>" . 'returned ' . $itemsFound . ' results.';
echo "</div>";
?>

<script id="template-image_description" type="text/x-jquery-tmpl">
    <div class="delete right">X</div>
    <div class="image_div">
        <img src="${imageFullSize}" />
    </div>
    <div class="group text_descr">
        <!--<div><strong>${imageFullSize}</strong></div> --> <!-- pkostov do we need that? It must be description NOT img path ?-->
        <br />

        <div><strong> ${collection} </strong></div>
        <div><a href="${instWebsite}" target="_new"><strong>${institution}</strong></a></div>

        <div>Other media that may interest you:</div>
        <div id="related_items" class="group">
            {{each related}}
            <div interest_id="${id}" class="item">
                <img src="${thumbnail}" />
            </div>
            {{/each}}
        </div>
        <div id="tags">
            {{each tags}}
            ${tag},
            {{/each}}
        </div>
    </div>
</script>

<script id="template-video_description" type="text/x-jquery-tmpl">
    <div style="display: flex-box; float: left; padding: 10px 20px;">
        <video class="video" controls preload poster="' . $url_poster . '">
            <source src="${url_mp4}"></source>
            <source src="${url_webm}"></source>
        </video>
    </div>
</script>
<script id="template-audio_description" type="text/x-jquery-tmpl">
    <div style="display: flex-box; float: left; padding: 10px 20px;">
        <audio class="audio" controls preload>
            <source src="${url_mp3}"></source>
            <source src="${url_ogg}"></source>
        </audio>
    </div>
</script>