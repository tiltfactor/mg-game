<?php
Yii::app()->clientScript->registerScript('combo', "
var drop2 = $('select[name=\"Custom[collections]\"] option');
$('select[name=\"Custom[institution]\"]').change(function () {
   var instID =  parseInt(this.value);
   var cDrop = $('select[name=\"Custom[collections]\"]');
   cDrop.empty();
   for(opt in drop2){
    cDrop.append(opt);
   }

   cDrop.find('option').filter(function(){
                        var id = this.attr('institution-id');
                        if(this.value==0) return true
                        else return (id == instID);
                      }).remove();
});
");
?>

<div class="wide form">

    <?php $form = $this->beginWidget('GxActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>

    <div class="row">
        <?php echo CHtml::label(Yii::t('app', "Tag(s)"), "Custom_tags") ?>
        <?php
        $this->widget('MGJuiAutoCompleteMultiple', array(
            'name' => 'Custom[tags]',
            'value' => ((isset($_GET["Custom"]) && isset($_GET["Custom"]["tags"])) ? $_GET["Custom"]["tags"] : ''),
            'source' => $this->createUrl('/admin/tag/searchTags'),
            'options' => array(
                'showAnim' => 'fold',
            ),
        ));
        ?>
        <?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
    </div>

    <div class="row small">
        <?php echo CHtml::label(Yii::t('app', "&nbsp;"), "") ?>
        <?php echo CHtml::radioButtonList("Custom[tags_search_option]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["tags_search_option"])) ? $_GET["Custom"]["tags_search_option"] : 'OR'), array("OR" => "OR", "AND" => "AND"), array(
        'template' => '<div class="inline-radio">{input} {label}</div>',
        'separator' => '',
    )) ?>
        <?php echo Yii::t('app', "(show medias that have at least one (OR) or all (AND) of the given tags)"); ?>
    </div>
    <!-- row -->

    <div class="row">
        <select id="institutionCombo" name="Custom[institution]">
            <option value="0">All</option>
            <?php
            foreach ($institutions as $ins)
                echo '<option value="' . $ins->id . '" data-shown="0,2">' . $ins->name . '</option>';
            ?>
        </select>
        <select id="collectionCombo" name="Custom[collections]">
            <option value="0" data-shown="0,0">All</option>
            <?php
            foreach ($institutions as $ins) {
                foreach ($ins->collections as $coll) {
                    echo '<option value="' . $coll->id . '" institution-id="' . $ins->id . '">' . $coll->name . '</option>';
                }
            }

            ?>
        </select>
    </div>
    <!-- row -->

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
