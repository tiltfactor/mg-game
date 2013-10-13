<?php
echo "<div class = \"imageInside\"><a href='#stayhere' class='image_hover'>";
echo generateImage($data);
//TODO NEED to be dynamic info from image
echo '<div class="image_description">{Collection Name} Collection '.stripcslashes($data['institution']->name).'</div>';
echo '<div class="center arrow"><img src="'.  SearchModule::getAssetsUrl().'/images/arrow.png" style="display: block;" /></div>';
echo '<div class="hidden json" style="display: none;">';
?>
{
    "result":
    [{
        "imageFullSize": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
        "imageScaled": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
        "thumbnail":  "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
        "videoWebm": "",
        "videoMp4": "",
        "audioMp3": "",
        "audioOgg": "",
        "licence": {
            "id": 1,
            "name": "Licence name",
            "description": "Licence description"
        },
        "collection": "Collection Name",
        "institution": "Institution name",
        "instWebsite": "http://www.yahoo.com",
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