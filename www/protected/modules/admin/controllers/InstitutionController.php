<?php

class InstitutionController extends GxController {

  public function filters() {
  	return array(
  			'accessControl', 
  			);
  }
  
  public function accessRules() {
  	return array(
  			array('allow',
  				'actions'=>array('view'),
  				'roles'=>array('*'),
  				),
  			array('allow', 
  				'actions'=>array('index','view', 'batch', 'create','update', 'admin', 'delete'),
  				'roles'=>array(EDITOR, EDITOR), // ammend after creation
  				),
  			array('deny', 
  				'users'=>array('*'),
  				),
  			);
  }

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Institution'),
		));
	}

	public function actionCreate() {
		$model = new Institution;
		$model->created = date('Y-m-d H:i:s'); 
     
    

		if (isset($_POST['Institution'])) {
			$model->setAttributes($_POST['Institution']);

			if ($model->save()) {
        MGHelper::log('create', 'Created Institution with ID(' . $model->id . ')');
				Flash::add('success', Yii::t('app', "Institution created"));
        if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else 
				  $this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Institution');
    
		if (isset($_POST['Institution'])) {
			$model->setAttributes($_POST['Institution']);

			if ($model->save()) {
                MGHelper::log('update', 'Updated Institution with ID(' . $id . ')');
                Flash::add('success', Yii::t('app', "Institution updated"));
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$model = $this->loadModel($id, 'Institution');
			if ($model->hasAttribute("locked") && $model->locked) {
			  throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
			} else {
			  $model->delete();
			  MGHelper::log('delete', 'Deleted Institution with ID(' . $id . ')');
        
        Flash::add('success', Yii::t('app', "Institution deleted"));

			  if (!Yii::app()->getRequest()->getIsAjaxRequest())
				  $this->redirect(array('admin'));
		  }
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new Institution('search');
        $model->unsetAttributes();

        if (isset($_GET['Institution']))
            $model->setAttributes($_GET['Institution']);

        $this->render('admin', array(
            'model' => $model,
        ));
	}

	public function actionAdmin() {
		$model = new Institution('search');
		$model->unsetAttributes();

		if (isset($_GET['Institution']))
			$model->setAttributes($_GET['Institution']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
  
  
  public function actionBatch($op) {
    if (Yii::app()->getRequest()->getIsPostRequest()) {
      switch ($op) {
        case "delete":
          $this->_batchDelete();
          break;
      }
      if (!Yii::app()->getRequest()->getIsAjaxRequest())
        $this->redirect(array('admin'));
    } else
      throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));  
    
  }

  private function _batchDelete() {
    if (isset($_POST['institution-ids'])) {
      $criteria=new CDbCriteria;
      $criteria->addInCondition("id", $_POST['institution-ids']);
            
      MGHelper::log('batch-delete', 'Batch deleted Institution with IDs(' . implode(',', $_POST['institution-ids']) . ')');
        
      $model = new Institution;
      $model->deleteAll($criteria);
        
    } 
  }
}