<?php

class PostController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

        private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{

            return array(
                array('allow',  // allow all users to perform 'list' and 'show' actions
                    'actions'=>array('index', 'view'),
                    'users'=>array('*'),
                ),
                array('allow', // allow authenticated users to perform any action
                    'users'=>array('@'),
                ),
                array('deny',  // deny all users
                    'users'=>array('*'),
                ),
            );

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

        public function actionIndex()
        {
            $criteria=new CDbCriteria(array(
                'condition'=>'status='.Post::STATUS_PUBLISHED,
                'order'=>'update_time DESC',
                'with'=>array('commentCount', 'author'),
            ));
            if(isset($_GET['tag']))
                $criteria->addSearchCondition('tags',$_GET['tag']);

            $dataProvider=new CActiveDataProvider('Post', array(
                'pagination'=>array(
                    'pageSize'=>5,
                ),
                'criteria'=>$criteria,
            ));

            $this->render('index',array(
                'dataProvider'=>$dataProvider,
            ));
        }
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

        public function actionView()
        {
            $post=$this->loadModel();
            $comment=$this->newComment($post);

            $this->render('view',array(
                'model'=>$post,
                'comment'=>$comment,
            ));
        }

//        protected function newComment($post)
//        {
//            $comment=new Comment;
//            if(isset($_POST['Comment']))
//            {
//                $comment->attributes=$_POST['Comment'];
//                if($post->addComment($comment))
//                {
//                    if($comment->status==Comment::STATUS_PENDING)
//                        Yii::app()->user->setFlash('commentSubmitted','Thank you...');
//                    $this->refresh();
//                }
//            }
//            return $comment;
//        }

        protected function newComment($post)
        {
            $comment=new Comment;

            if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
            {
                echo CActiveForm::validate($comment);
                Yii::app()->end();
            }

            if(isset($_POST['Comment']))
            {
                $comment->attributes=$_POST['Comment'];
                if($post->addComment($comment))
                {
                    if($comment->status==Comment::STATUS_PENDING)
                        Yii::app()->user->setFlash('commentSubmitted','Спасибо!');
                    $this->refresh();
                }
            }
            return $comment;
        }

        public function loadModel()
        {
            if($this->_model===null)
            {
                if(isset($_GET['id']))
                {
                    if(Yii::app()->user->isGuest)
                        $condition='status='.Post::STATUS_PUBLISHED
                            .' OR status='.Post::STATUS_ARCHIVED;
                    else
                        $condition='';
                    $this->_model=Post::model()->findByPk($_GET['id'], $condition);
                }
                if($this->_model===null)
                    throw new CHttpException(404,'Запрашиваемая страница не существует.');
            }
            return $this->_model;
        }

}
