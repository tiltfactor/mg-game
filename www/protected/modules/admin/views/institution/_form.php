<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'institution-form',
	'enableAjaxValidation' => false,
    'clientOptions'=>array('validateOnSubmit'=>true),
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
    <?php echo $form->labelEx($model,'name'); ?>
    <?php echo $form->textField($model, 'name', array('maxlength' => 128)); ?>
    <?php echo $form->error($model,'name'); ?>
    </div><!-- row -->
    <div class="row">
    <?php echo $form->labelEx($model,'url'); ?>
    <?php echo $form->textField($model, 'url', array('maxlength' => 128)); ?>
    <?php echo $form->error($model,'url'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model,'website'); ?>
        <?php echo $form->textField($model, 'website', array('maxlength' => 255)); ?>
        <?php echo $form->error($model,'website'); ?>
    </div><!-- row -->
    <div class="row">
    <?php echo $form->labelEx($model,'token'); ?>
    <?php echo $form->textField($model, 'token', array('maxlength' => 128)); ?>
    <?php echo $form->error($model,'token'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status',Institution::itemAlias('Status')); ?>
        <?php echo $form->error($model,'status'); ?>
    </div><!-- row -->
    <div class="row">
    <?php if($model->created != 0) : ?>
    <?php echo $form->labelEx($model,'created'); ?>
    <?php echo $model->created; ?>
    <?php endif; ?>
    </div><!-- row -->


<?php
echo GxHtml::submitButton($buttons);
$this->endWidget();
?>
</div><!-- form -->