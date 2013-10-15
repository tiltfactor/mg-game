<a class="listview-image" href="<?php echo Yii::app()->createURL("/admin/media/view", array("id" => $data["id"])); ?>">
  <?php echo CHtml::image(MGHelper::getMediaThumb($data["url"],"image",$data["name"]), $data["name"]);?>
  <span><?php echo $data["name"]; ?> (<?php echo $data["counted"]; ?>/<?php echo $data["tag_counted"]; ?>)</span>
</a>