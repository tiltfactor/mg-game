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
        <?php echo CHtml::label(Yii::t('app', "Institution(s)"), "Custom_institutions") ?>
        <?php echo CHtml::checkBoxList("Custom[institutions]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["institutions"])) ? $_GET["Custom"]["institutions"] : ''), GxHtml::encodeEx(GxHtml::listDataEx(Institution::model()->findAllAttributes(null, true)), false, true), array(
        'template' => '<div class="checkbox">{input} {label}</div>',
        'separator' => '',
    )); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo CHtml::label(Yii::t('app', "Collection(s)"), "Custom_collections") ?>
        <?php echo CHtml::checkBoxList("Custom[collections]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["collections"])) ? $_GET["Custom"]["collections"] : ''), GxHtml::encodeEx(GxHtml::listDataEx(Collection::model()->findAllAttributes(null, true)), false, true), array(
        'template' => '<div class="checkbox">{input} {label}</div>',
        'separator' => '',
    )); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo CHtml::label(Yii::t('app', "Media type(s)"), "Custom_media_type") ?>
        <?php echo CHtml::checkBoxList("Custom[media_types]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["media_types"])) ? $_GET["Custom"]["media_types"] : ''), GxHtml::encodeEx(array('image'=>'image','video'=>'video','audio'=>'audio'), false, true), array(
        'template' => '<div class="checkbox">{input} {label}</div>',
        'separator' => '',
    )); ?>
    </div>
    <!-- row -->

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
