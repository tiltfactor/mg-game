<div class="wide form">

    <?php $form = $this->beginWidget('GxActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>
    <div id="metadatagameslogo">
        <!--TODO Insert image here   [Yii::app()->theme->baseUrl]-->
    </div>
    <div class="row"> <!-- ROW 1 [Tags, Search, Advanced Search]-->
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
        <div id="advancedButton">
        <?php echo CHtml::link('Advanced search'); ?>
        </div>
    </div> <!--End ROW 1-->

    <div id="advancedSearch">  <!--advancedSearch-->
    <div class="row small"> <!-- ROW 2 [OR AND]-->
        <?php echo CHtml::label(Yii::t('app', "&nbsp;"), "") ?>
        <?php echo CHtml::radioButtonList("Custom[tags_search_option]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["tags_search_option"])) ? $_GET["Custom"]["tags_search_option"] : 'OR'), array("OR" => "OR", "AND" => "AND"), array(
        'template' => '<div class="inline-radio">{input} {label}</div>',
        'separator' => '',
    )) ?>
        <?php echo Yii::t('app', "(show medias that have at least one (OR) or all (AND) of the given tags)"); ?>
    </div> <!--End ROW 2-->
    <!-- row -->
    <div class="row"> <!-- ROW 3 [Institutions]-->
        <?php echo CHtml::label(Yii::t('app', "Institution(s)"), "Custom_institutions") ?>
        <?php echo CHtml::checkBoxList("Custom[institutions]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["institutions"])) ? $_GET["Custom"]["institutions"] : ''), GxHtml::encodeEx(GxHtml::listDataEx(Institution::model()->findAllAttributes(null, true)), false, true), array(
        'template' => '<div class="checkbox">{input} {label}</div>',
        'separator' => '',
    )); ?>
    </div> <!--End ROW 3-->
    <!-- row -->
    <div class="row"> <!-- ROW 4 [Collections]-->
        <?php echo CHtml::label(Yii::t('app', "Collection(s)"), "Custom_collections") ?>
        <?php echo CHtml::checkBoxList("Custom[collections]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["collections"])) ? $_GET["Custom"]["collections"] : ''), GxHtml::encodeEx(GxHtml::listDataEx(Collection::model()->findAllAttributes(null, true)), false, true), array(
        'template' => '<div class="checkbox">{input} {label}</div>',
        'separator' => '',
    )); ?>
    </div> <!--End ROW 4-->
    <!-- row -->
    <div class="row"> <!-- ROW 5 [Media types]-->
        <?php echo CHtml::label(Yii::t('app', "Media type(s)"), "Custom_media_type") ?>
        <?php echo CHtml::checkBoxList("Custom[media_types]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["media_types"])) ? $_GET["Custom"]["media_types"] : ''), GxHtml::encodeEx(array('image'=>'image','video'=>'video','audio'=>'audio'), false, true), array(
        'template' => '<div class="checkbox">{input} {label}</div>',
        'separator' => '',
    )); ?>
    </div>  <!--End ROW 5-->
   </div>     <!--End advancedSearch-->
    <!-- row -->

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
