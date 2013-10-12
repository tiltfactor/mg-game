<?php
echo "<div class = \"imageInside\"><a href='#stayhere' class='image_hover'>";
echo generateImage($data);
//TODO NEED to be dynamic info from image
echo '<div class="image_description">{Collection name} Collection {Institution name}</div>';
echo '<div class="hidden json" style="display: none;">';
?>
{
    "result":
    [{
        "img": "http://localhost/mgc_1/www/uploads/images/image002_1.jpg",
        "video": "..",
        "media": "image",
        "related": [
            {
            "thumb": "http://www.yahoo.com/",
            "name": "Sample image"
            },
            {
            "thumb": "http://www.yahoo.com/",
            "name": "Sample image"
            }
        ]
    }]
}
<?php
echo '</div>';
echo "</a>";
echo "</div>";