<a class="listview-image" href="<?php echo Yii::app()->createURL("/admin/media/view", array("id" => $data["id"])); ?>">
  <?php echo CHtml::image(MGHelper::getMediaThumb($data["url"],$data["mime_type"],$data["name"]), $data["name"]);?><span><?php echo $data["name"]; ?>
  </span> <span><?php echo $data["counted"]; ?>/<?php echo $data["user_counted"]; ?></span>
</a>