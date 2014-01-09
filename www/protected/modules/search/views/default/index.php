<?php
    $form = $this->beginWidget('GxActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>

<div class="search-form" style="display: block;">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
        'institutions' => $institutions
    )); ?>
</div><!-- search-form -->


<?php

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

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
};

$mediaResults = $model->search(true);
$total = count($mediaResults->getData());
$items = $mediaResults->getData();
global $currentUserRole;
$currentUserRole = $userRole;
global $relatedMedia;
$relatedMedia = array();
foreach($items as $key=>&$data){
    $relatedMedia[$data->id] = array();
    $index = $key+1;
    if($index>=$total) $index = 0;
    if($total<8) $index = $key+1;
    for($i=0;$i<$total;$i++){
        $relate = array("id"=>$items[$index]->id,
                        "thumb"=>MGHelper::getMediaThumb($items[$index]->institution->url,$items[$index]->mime_type,$items[$index]->name));
        $index++;
        if(($key + 1) == $index && $total<8) continue;
        array_push($relatedMedia[$data->id],$relate);
        if($index>=$total) $index = 0;
    }
}

$gameStatHtml = '<div id="gameStat">Games played: ' . SearchModule::getGameStats("no_of_games_played") .
            ' | Tags submitted: ' . SearchModule::getGameStats("no_of_tags_submitted") . '</div>';

echo '
    <div class="main_content box">';
$options = array ('10' => '10', '15' => '15', '20'=>'20', '25'=>'25' );
$sorterOptions = array('relevance' => 'Relevance', 'a_z' => 'A-Z', 'z_a'=>'Z-A');
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$mediaResults,
    'itemView'=>'_viewSearch',   // refers to the partial view named '_viewSearch'
    'ajaxUpdate'=>false,
    'enablePagination'=>true,
    'template'=>"<div id = \"levelOneHolder\">{summary}<div class = \"itemsPerPage\">Items per page: " . CHtml::dropDownList('Custom[items_per_page]', $setItemsPerPage, $options) . "</div>" . 'Sort by: ' . CHtml::dropDownList('Custom[type_sort]', $setTypeOrder, $sorterOptions) . $gameStatHtml ."{pager}</div>{items}", //pager on top
    'summaryText'=>" ",
));
echo '</div>';
$this->endWidget();

echo "<div id=\"totalItemsFound\">";
$itemsFound =  totalItemsFound($mediaResults);
if($itemsFound != 0) echo  'Your search ' .   "<div id=\"putFor\"> </div>"  .' '. "<div id=\"searchedValue\"> </div>" . ' returned ' . $itemsFound . ' results.';
echo "</div>";
?>

<script id="template-image_description" type="text/x-jquery-tmpl">
    <div class="delete right">X</div>
    <div class="image_div" >
        <img src="${imageFullSize}" />
    </div>
    <div class="group text_descr">
        <div class="mediaDescription">
           <div class="collection"><strong>${collection} </strong></div>
            <div><strong><a class="institutionWebsite" href='${instWebsite}' target="_blank">${institution}</strong></a></div>
            <div class="licence">${licence}</div>
            <div class="otherMediaInterests">Other media that may interest you:</div>
       </div>
        <div id="related_items" class="group">
            {{each related}}
            <div class="item">
                <img class="thumbnails" src="${thumbnail}" onclick="$('#${id}').trigger('click');" style="cursor: pointer;"  <?php echo 'test=mytest';?>/>
            </div>
            {{/each}}
        </div>
        <div id="tags">
            <!--{{each tags}}
            ${tag}
            {{/each}}-->
            ${tags}
        </div>
    </div>
</script>

<script id="template-video_description" type="text/x-jquery-tmpl">
    <div class="delete right">X</div>
    <div class="image_div">
        <video class="video" controls preload poster="${videoPoster}" width="480" height="320">
            <source src="${videoWebm}"></source>
            <source src="${videoMp4}"></source>
        </video>
    </div>
    <div class="group text_descr">
        <br />
      <div class="mediaDescription">
        <div class="collection"><strong>${collection} </strong></div>
        <div><strong><a class="institutionWebsite" href= ${instWebsite} target="_blank">${institution} </strong></a></div>
        <div class="licence">${licence}</div>
        <div class="otherMediaInterests">Other media that may interest you:</div>
       </div>
        <div id="related_items" class="group">
            {{each related}}
            <div class="item">
                <img src="${thumbnail}" onclick="$('#${id}').trigger('click');" style="cursor: pointer;"/>
            </div>
            {{/each}}
        </div>
        <div id="tags">
            <!--{{each tags}}
            ${tag}
            {{/each}}-->
            ${tags}
        </div>
    </div>
</script>
<script id="template-audio_description" type="text/x-jquery-tmpl">
    <div class="delete right">X</div>
    <div class="image_div">
        <audio class="audio" controls preload>
            <source src="${audioMp3}"></source>
            <source src="${audioOgg}"></source>
        </audio>
    </div>
    <div class="group text_descr">
        <br />
     <div class="mediaDescription">
        <div class="collection"><strong>${collection} </strong></div>
        <div><strong><a class="institutionWebsite" href=${instWebsite} target="_blank">${institution}</strong></a></div>
        <div class="licence">${licence}</div>
        <div class="otherMediaInterests">Other media that may interest you:</div>
     </div>
        <div id="related_items" class="group">
            {{each related}}
            <div class="item" >
                <img src="${thumbnail}" onclick="$('#${id}').trigger('click');" style="cursor: pointer;"/>
            </div>
            {{/each}}
        </div>
        <div id="tags">
            <!--{{each tags}}
            ${tag}
            {{/each}}-->
            ${tags}
        </div>
    </div>
</script>
