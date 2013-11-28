<div class="wide form">


    <div id="searchHeader">
        <div id="metadatagameslogo">
            <img src="<?php echo SearchModule::getAssetsUrl(); ?>/images/metadatagamesLogo.png" alt="MetaDataGames Logo"/>
        </div>

        <div class="row" id="searchRow"> <!-- ROW 1 [Tags, Search]-->
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
            <?php
            echo CHtml::imageButton(SearchModule::getAssetsUrl() . "/images/search_small.png", $htmlOptions=array('id' => 'imageButton'));
            ?>
			<div id="playTagConnect"><img src="<?php echo SearchModule::getAssetsUrl(); ?>/images/playTagConnectLogo.png" alt="MetaDataGames Logo"/></div>
        </div>
    </div>

    <?php
    $institutions = Institution::model()->findAll('status=1');
    $collections = array();
    $myInstitutions = array();
    foreach($institutions as $row){
        $collections = array_merge($collections,$row->collections);
        $myInstitutions [$row->id] = $row->name;
    }
    $colls = Collection::model()->with('institution')->findAll('status=1');
    $myCollections = array();
    foreach($colls as $row)
    {
        $myCollections = array_merge($myCollections,array(array('id'=>$row->id,'name'=> $row->name,'institution_id'=>$row->institution_id)));
    }
    echo '<div id="collectionToInstitution" class="hidden json" style="display: none;">' . json_encode($myCollections) .  '</div>';


    echo '<div class="group refine" style="background-color:white/* #E3E3E3*/;">
    <div class="menu">
        Refine
        <div id="or_and" class="group">
            <div class="separator"></div>
            <div>Show media that have at least one (OR) or all (AND) of the given tags</div>
            <div class="menu_item">';
    echo CHtml::radioButtonList("Custom[tags_search_option]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["tags_search_option"])) ? $_GET["Custom"]["tags_search_option"] : 'OR'), array("OR" => "OR", "AND" => "AND"), array(
        'template' => '<div class="inline-radio">{input} {label}</div>',
        'separator' => '',
    ));
    echo '
            </div>
        </div>
        <div id="by_institution" class="group">
            <div class="separator"></div>
            <div>By Institution</div>
            </br>
            <div class="menu_item">';
    echo CHtml::checkBoxList("Custom[institutions]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["institutions"])) ? $_GET["Custom"]["institutions"] : ''), GxHtml::encodeEx(GxHtml::listDataEx($institutions), false, true), array(
        'template' => '{input} {label}',
        'separator' => '<br />',
    ));

    echo        '</div>
        </div>
        <div id="by_collection" class="group">
            <div class="separator"></div>
            <div>By Collection</div>
            <div class="menu_item">';
    echo CHtml::checkBoxList("Custom[collections]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["collections"])) ? $_GET["Custom"]["collections"] : ''), GxHtml::encodeEx(GxHtml::listDataEx($collections), false, true), array(
        'template' => '{input} {label}',
        'separator' => '<br />',
    ));
    echo '
            </div>
        </div>
        <div id="by_format" class="group">
            <div class="separator"></div>
            <div>By Format</div>
            <div class="menu_item">';
    echo CHtml::checkBoxList("Custom[media_types]", ((isset($_GET["Custom"]) && isset($_GET["Custom"]["media_types"])) ? $_GET["Custom"]["media_types"] : ''), GxHtml::encodeEx(array('image'=>'image','video'=>'video','audio'=>'audio'), false, true), array(
        'template' => '{input} {label}',
        'separator' => '<br />',
    ));


    ?>

    <?php
    echo '
            </div>
        </div>
    </div>';
    ?>

    <!--</div>--><!-- search-form -->
