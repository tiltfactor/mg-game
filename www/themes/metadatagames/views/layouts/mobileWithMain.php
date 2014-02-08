<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="content-language" content="en" />
    <meta id="Viewport" name="viewport" content="width=device-width, initial-scale=.5, maximum-scale=1, user-scalable=yes" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/normalize.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mmenu.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mmenu-positioning.css" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
  <div id='mainmenu_save'>
		<div id="header">
		  <a id="page_title" class="ir" href="<?php echo MGHelper::bu("/"); ?>"><?php CHtml::encode(Yii::app()->fbvStorage->get("settings.app_name")); ?></a>
		  <div id="mainmenu">
		  <?php
		  $this->widget('application.components.MGMenu',array(
		    'items'=>array(
		      array('label'=>'Search', 'url'=>array('/search')),
		      array('label'=>'Arcade', 'url'=>array('/site/arcade'), 'visible'=>(Yii::app()->user->checkAccess(EDITOR) || Yii::app()->user->checkAccess(INSTITUTION))), // junjie guan: control the acrade here
		      array('label'=>'Contact', 'url'=>array('/site/contact')),
		      array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login"), 'visible'=>Yii::app()->user->isGuest),
		      array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Register"), 'visible'=>Yii::app()->user->isGuest),
		      array('url'=>array('/admin'), 'label'=>Yii::t('app', 'Admin'), 'visible'=>(Yii::app()->user->checkAccess(EDITOR) || Yii::app()->user->checkAccess(INSTITUTION))),
		      array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Profile"), 'visible'=>!Yii::app()->user->isGuest),
		      array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest)
		    ),
		
		  ));
		  ?></div><!-- mainmenu -->
		
		  <div id="usersonline">
		  <!-- Stubbing in code for number of users online -->
		<?php
		// 2013-04-07 - qubit - Disable user counter by default (mostly disabled in many builds)
		// Properly initialize the values in the counter.
		//Yii::app()->counter->refresh();
		//
		//$num = Yii::app()->counter->getOnline();
		//echo "<span>There " . ($num == 1 ? "is" : "are") . " $num user" .
		//  ($num == 1 ? "" : "s") . " online.</span>";
		?>
		  </div><!-- usersonline -->
		</div>
	</div>

<div id="ppitest" style="width:1in;height:0px;padding:0px"></div>
<?php echo $content; ?>

</body>
</html>