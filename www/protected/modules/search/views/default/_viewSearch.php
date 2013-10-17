<?php

global $relatedMedia;
$tagsString = "";
foreach ($data->tagUses as $currentTag)
{
    $tagsString .= $currentTag->tag->tag . " ";
}
echo "<div class = \"imageInside\"><a href='#stayhere' class='image_hover'>";
echo "<img src = " . MGHelper::getScaledMediaUrl($data->name, 160, 120, $data->institution->token, $data->institution->url) . " >";
//TODO NEED to be dynamic info from image
echo '<div class="image_description"> '. $data->listCollectionsText(). '</br>'  . stripcslashes($data['institution']->name) .'</div>' ;
echo '<div class="center arrow"><img src="'.  SearchModule::getAssetsUrl().'/images/arrow.png" style="display: block;" /></div>';
echo '<div class="hidden json" style="display: none;">';

?>
    {
    "result":
    [{
    "imageFullSize": "<?php echo MGHelper::getScaledMediaUrl($data->name, 640, 480, $data->institution->token, $data->institution->url); ?>",
    "imageScaled": "",
    "thumbnail": "<?php echo  MGHelper::getMediaThumb($data->institution->url,$data->mime_type,$data->name); ?>",
    "videoWebm": "",
    "videoMp4": "",
    "audioMp3": "",
    "audioOgg": "",
    "licence": {
    "id": "<?php echo $data->id ?>",
    "name": "<?php echo $data->name ?>",
    "description": ""
    },
    "collection": "<?php echo $data->listCollectionsText() ?>",
    "institution": "<?php echo $data->institution->name?>",
    "instWebsite": "<?php echo $data->institution->website ?>",
    "tags": " <?php echo $tagsString; ?>",
    "mimeType": "<?php echo substr($data->mime_type, 0, 5); ?>",
    "related": [
    {
    "imageFullSize": "",
    "imageScaled": "",
    "thumbnail":  "<?php echo  $relatedMedia[$data->id][0] ?>"
    },
    {
    "imageFullSize": "",
    "imageScaled": "",
    "thumbnail":  "<?php echo  $relatedMedia[$data->id][1] ?>"
    },
    {
    "imageFullSize": "",
    "imageScaled": "",
    "thumbnail":  "<?php echo  $relatedMedia[$data->id][2] ?>"
    },
    {
    "imageFullSize": "",
    "imageScaled": "",
    "thumbnail":  "<?php echo  $relatedMedia[$data->id][3] ?>"
    },
    {
    "imageFullSize": "",
    "imageScaled": "",
    "thumbnail":  "<?php echo  $relatedMedia[$data->id][4] ?>"
    },
    {
    "imageFullSize": "",
    "imageScaled": "",
    "thumbnail":  "<?php echo  $relatedMedia[$data->id][5] ?>"
    },
    {
    "imageFullSize": "",
    "imageScaled": "",
    "thumbnail":  "<?php echo  $relatedMedia[$data->id][6] ?>"
    },
    {
    "imageFullSize": "",
    "imageScaled": "",
    "thumbnail":  "<?php echo  $relatedMedia[$data->id][7] ?>"
    }
    ]
    }]
    }
<?php
echo '</div>';
echo "</a>";
echo "</div>";