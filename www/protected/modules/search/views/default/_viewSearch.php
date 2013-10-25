<?php
global $currentUserRole;
global $relatedMedia;
$tagsString = "";
foreach ($data->tagUses as $currentTag) {
    $tagsString .= $currentTag->tag->tag . ", ";
}
$mediaType = substr($data->mime_type, 0, 5);
$src = "";
$urlWebm ="";
$urlMp4="";
$urlMp3="";
$urlOgg="";
if($mediaType == 'image'){
    $src = MGHelper::getScaledMediaUrl($data->name, 160, 120, $data->institution->token, $data->institution->url);
}else if ($mediaType === 'video') {
    $src =  MGHelper::getMediaThumb($data->institution->url, $data->mime_type, $data->name);
    $urlWebm = $data->institution->url . UPLOAD_PATH . '/videos/' . urlencode($data->name);
    $urlMp4 = $data->institution->url . UPLOAD_PATH . '/videos/' . urlencode(substr($data->name, 0, -4) . "mp4");
} else {
    $src =  MGHelper::getMediaThumb($data->institution->url, $data->mime_type, $data->name);
    $urlMp3 = $data->institution->url . UPLOAD_PATH . '/audios/' . urlencode($data->name);
    $urlOgg = $data->institution->url . UPLOAD_PATH . '/audios/' . urlencode(substr($data->name, 0, -3) . "ogg");
}

$licences = array();
foreach($data->collections as $col){
    if(!in_array($col->licence->name,$licences)){
        array_push($licences,$col->licence->name);
    }
}
$licenceStr = 'copyright ' .  implode(',',$licences);

echo "<div class = \"imageInside\" id=\"".$data->id."\"><a href='#stayhere' class='image_hover'>";
echo "<img src = " . $src . " >";
//TODO NEED to be dynamic info from image
echo '<div class="image_description"> ' . $data->listCollectionsText() . '</br>' . stripcslashes($data['institution']->name) . '</div>';
echo '<div class="center arrow"><img src="' . SearchModule::getAssetsUrl() . '/images/arrow.png" style="display: block;" /></div>';
echo '<div class="hidden json" style="display: none;">';



?>
{
"result":
[{
"imageFullSize": "<?php echo MGHelper::getScaledMediaUrl($data->name, 640, 480, $data->institution->token, $data->institution->url); ?>",
"imageScaled": "",
"thumbnail": "<?php echo  MGHelper::getMediaThumb($data->institution->url, $data->mime_type, $data->name); ?>",
"videoWebm": "<?php echo $urlWebm;?>",
"videoMp4": "<?php echo $urlMp4;?>",
"videoPoster": "<?php echo $src;?>",
"audioMp3": "<?php echo $urlMp3;?>",
"audioOgg": "<?php echo $urlOgg;?>",
"licence":  "<?php echo $licenceStr; ?>",
"collection": "<?php echo $data->listCollectionsText() ?>",
"institution": "<?php echo $data->institution->name ?>",
"instWebsite": "<?php
                if(startsWith($data->institution->website, 'http://')) echo $data->institution->website;
                else echo 'http://' . $data->institution->website
    ?>",
"tags": " <?php
                if($currentUserRole == ADMIN || $currentUserRole == EDITOR || $currentUserRole == INSTITUTION) echo $tagsString;
                else echo '';
            ?>",
"mimeType": "<?php echo substr($data->mime_type, 0, 5); ?>",
"related": [
{
"id": "<?php echo  $relatedMedia[$data->id][0]["id"] ?>",
"thumbnail":  "<?php echo  $relatedMedia[$data->id][0]["thumb"] ?>"
},
{
"id": "<?php echo  $relatedMedia[$data->id][1]["id"] ?>",
"thumbnail":  "<?php echo  $relatedMedia[$data->id][1]["thumb"] ?>"
},
{
"id": "<?php echo  $relatedMedia[$data->id][2]["id"] ?>",
"thumbnail":  "<?php echo  $relatedMedia[$data->id][2]["thumb"] ?>"
},
{
"id": "<?php echo  $relatedMedia[$data->id][3]["id"] ?>",
"thumbnail":  "<?php echo  $relatedMedia[$data->id][3]["thumb"] ?>"
},
{
"id": "<?php echo  $relatedMedia[$data->id][4]["id"] ?>",
"thumbnail":  "<?php echo  $relatedMedia[$data->id][4]["thumb"] ?>"
},
{
"id": "<?php echo  $relatedMedia[$data->id][5]["id"] ?>",
"thumbnail":  "<?php echo  $relatedMedia[$data->id][5]["thumb"] ?>"
},
{
"id": "<?php echo  $relatedMedia[$data->id][6]["id"] ?>",
"thumbnail":  "<?php echo  $relatedMedia[$data->id][6]["thumb"] ?>"
},
{
"id": "<?php echo  $relatedMedia[$data->id][7]["id"] ?>",
"thumbnail":  "<?php echo  $relatedMedia[$data->id][7]["thumb"] ?>"
}
]
}]
}
<?php
echo '</div>';
echo "</a>";
echo "</div>";