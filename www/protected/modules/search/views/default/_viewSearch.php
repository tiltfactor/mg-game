<?php
echo "<div class = \"imageInside\"><a href='#stayhere' class='image_hover'>";
echo "<img src = " . MGHelper::getScaledMediaUrl($data->name, 160, 120, $data->institution->token, $data->institution->url) . " >";
//TODO NEED to be dynamic info from image
echo '<div class="image_description">{Collection Name} Collection '.stripcslashes($data['institution']->name).'</div>';
echo '<div class="center arrow"><img src="'.  SearchModule::getAssetsUrl().'/images/arrow.png" style="display: block;" /></div>';
echo '<div class="hidden json" style="display: none;">';
?>
    {
    "result":
    [{
    "imageFullSize": "<?php echo MGHelper::getScaledMediaUrl($data->name, 640, 480, $data->institution->token, $data->institution->url); ?>",
    "imageScaled": "",
    "thumbnail":  "<?php echo  MGHelper::getMediaThumb($data->institution->url,$data->mime_type,$data->name); ?>",
    "videoWebm": "",
    "videoMp4": "",
    "audioMp3": "",
    "audioOgg": "",
    "licence": {
    "id": 1,
    "name": "Licence name",
    "description": "Licence description"
    },
    "collection": "Collection ",
    "institution": "<?php echo $data->institution->name?>",
    "instWebsite": "<?php echo $data->institution->url ?>",
    "tags": [
    {"tag": "boat"},
    {"tag": "wooden"}
    ],
    "mimeType": "image",
    "related": [
    {
    "id": 12,
    "imageFullSize": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "imageScaled": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "thumbnail":  "http://localhost/mgc_1/www/uploads/images/image002_1.jpg"
    },
    {
    "imageFullSize": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "imageScaled": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "thumbnail":  "http://localhost/mgc_1/www/uploads/images/image002_1.jpg"
    },
    {
    "imageFullSize": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "imageScaled": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "thumbnail":  "http://localhost/mgc_1/www/uploads/images/image002_1.jpg"
    },
    {
    "imageFullSize": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "imageScaled": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "thumbnail":  "http://localhost/mgc_1/www/uploads/images/image002_1.jpg"
    },
    {
    "imageFullSize": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "imageScaled": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "thumbnail":  "http://localhost/mgc_1/www/uploads/images/image002_1.jpg"
    },
    {
    "imageFullSize": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "imageScaled": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "thumbnail":  "http://localhost/mgc_1/www/uploads/images/image002_1.jpg"
    },
    {
    "imageFullSize": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "imageScaled": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "thumbnail":  "http://localhost/mgc_1/www/uploads/images/image002_1.jpg"
    },
    {
    "imageFullSize": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "imageScaled": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
    "thumbnail":  "http://localhost/mgc_1/www/uploads/images/image002_1.jpg"
    }
    ]
    }]
    }
<?php
echo '</div>';
echo "</a>";
echo "</div>";