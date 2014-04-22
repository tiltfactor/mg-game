<?php $this->pageTitle=Yii::app()->fbvStorage->get("settings.app_name") . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);

$this->menu = array(
  array('label'=>UserModule::t('Manage Players'), 'url'=>array('/admin/user'), 'visible'=>Yii::app()->user->checkAccess(ADMIN)),
  array('label' => UserModule::t('Edit Profile'), 'url'=>array('profile/edit')),
);
?><h2><?php echo UserModule::t('Your profile'); ?></h2>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('username')); ?></th>
  <td><?php echo CHtml::encode($model->username); ?></td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('email')); ?></th>
    <td><?php echo CHtml::encode($model->email); ?>
</td>
</tr>
<?php
  $profileFields=ProfileField::model()->forOwner()->sort()->findAll();
  if ($profileFields) {
    foreach($profileFields as $field) { ?>
<tr>
  <th class="label"><?php echo CHtml::encode(UserModule::t($field->title)); ?></th>
  <td><?php echo (($field->widgetView($profile))?$field->widgetView($profile):CHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); ?></td>
</tr>
<?php
    }
  }
?>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('created')); ?></th>
    <td><?php echo $model->created; ?></td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?></th>
  <td><?php echo $model->lastvisit; ?></td>
</tr>
</table>

<h2>Interests</h2>
<?php $this->widget('PlayerSubjectMatter', array('user_id' => $model->id)); ?>

<h2>Games Info</h2>
<h3>Top Scores Since Sunday</h3>
<?php
    $topscore = GamesModule::getRecentTopPlayers();
    $games = GamesModule::getActiveGames();
?>
<?php if ($games) : ?>
<!-- good example of the dynamic tab: http://www.yiiframework.com/wiki/393/cjuitabs-content/-->
    <?php
    $x=1;
    foreach($games as $game){
        $tabarray["<span id='tab-$game->id' style='$css'>$game->unique_id</span>"]=array('id'=>$game->id,'content'=>$this->renderPartial(
                'topscore',
                array('game'=>$game,'scores'=>$topscore[$x]),TRUE
            ));
        $x++;
    }
    ?>
    <?php
    $this->widget('zii.widgets.jui.CJuiTabs',array(
        'tabs'=>$tabarray,
        // additional javascript options for the accordion plugin
        'options' => array(
            'collapsible' => true,
            'show'  => true,
        ),
        'id'=>'topscores-tab'
    ));
    ?>
    <?php else : ?>
    <p>No high scores available</p>
<?php endif; ?>
<?php if (Yii::app()->user->isGuest) :?>
    <?php $this->widget('AwardedBadges'); ?>
<?php else : ?>
    <?php $this->widget('PlayerStatus'); ?>
    <?php $this->widget('PlayerBadges'); ?>
<?php endif;?>

