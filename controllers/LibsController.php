<?php

namespace app\controllers;

use Yii;
use app\models\History;
use app\models\Books;
use app\models\Users;

use yii\web\UploadedFile;
use yii\imagine\Image;

use app\models\HistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Url;
use yii\filters\AccessControl;
use app\models\LoginForm;


/**
 * LibsController implements the CRUD actions for History model.
 */
class LibsController extends Controller
{
    /**
     * @inheritdoc
     */
   
	 public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
	
	/**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * Lists all History models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	
	
    /**
     * Displays a single History model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id = 0)
    {
		
		if(Yii::$app->request->post())
		{
			//проверка валидации!!!!!!!!!!!!!
			
			//переход по истории
			$id_hist = Yii::$app->request->post('id_hist');
			$id_book = Yii::$app->request->post('id_book');
			
			if($id_hist and $id_book)
			{
				return $this->toogleHist($id_book, $id_hist);
			}
			
			//Дать разрешение на изменение записи
			$id_access = Yii::$app->request->post('id_access');
			
			if($id_access >= 0 and $id_book)
			{
				$books = Books::findOne($id_book);
				$books->access = $id_access;
				$books->save();
				
			}	
			
			return true;
		
		}	
		
		$is_exist = History::findOne([
					'id_book' => $id,
					'active_ver' => 1
				]);
		
		if(!$is_exist)
		        throw new NotFoundHttpException('The requested page does not exist.');
			
		$model = History::find()
					->where(['=', 'books.id',$id])
					->joinWith('books' ,'books.id_owner = users.id')
					->joinWith('users')
					->all();
		
		
		$active_book;
					
		foreach($model as $val)
		{
			if($val->active_ver)
			     $active_book = $val;
			
		}
		
        return $this->render('view', [
            'model' => $model ,
            'book' => $active_book,
        ]);
    }

	private function toogleHist ($id_book, $id_hist)
	{
		
		$hist_list = History::find()->where(['=', 'id_book',$id_book])->all();
		
        $result = null;		
				
		foreach($hist_list as $hist)
		{
			if($hist->id == $id_hist)
			{	
				  $hist->active_ver = 1;
				  $result = \yii\helpers\ArrayHelper::toArray($hist);
			}	  
			else 
				  $hist->active_ver = 0;
			  
			$hist->update(false);
		}
		
		$result['update_link'] = Url::to(['libs/update', 'id' => $result['id']]);
		
		 Yii::$app->response->format = Response::FORMAT_JSON;

		return $result;
	}
	
    /**
     * Creates a new History model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   
	
	public function actionCreate()
    {
    
         $model = new History();
	   

        if ($model->load(Yii::$app->request->post())) {
			
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
          
			 if ($model->saveBook()) {
				 
				 $this->saveImage($model);
				 
				 return $this->redirect(['view', 'id' => $model->id_book]);
			} 
        }
	    else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	////сохранение изображения 
	private function saveImage ($model)
	{
			 $model->imageFile->saveAs('uploads/'.$model->image);
		      
			 Image::thumbnail('@webroot/uploads/'.$model->image, 200, 200)
                         ->save(Yii::getAlias('@webroot/uploads/prev/'.$model->image), ['quality' => 80]);
		     
			 return true;
	}

    /**
     * Updates an existing History model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
              
		 //эта модель для валидации и соотв. для формы
		$model = History::findOne($id);
				
        if ($model->load(Yii::$app->request->post()) ) {
			
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
		    
			if(empty($model->imageFile))
				$model->scenario = History::SCENARIO_UPDATE;
			
			if($model->validate())
			{
				//создадим обьект для новой записи
				$insert = new History();
				//тут просто заполняем необходимые поля для новой записи
				$insert->insertBook($model);
				
				
				// обьект для проверки изменения данных
				//и отправки его в историю (если проверка пройдет успешно)
				$check_data = History::findOne($id);
				
				$flag = empty($model->imageFile)?true:false;
				$flag = ($flag and $check_data->year == $model->year)?true:false;
				$flag = ($flag and $check_data->book_name == $model->book_name)?true:false;
				$flag = ($flag and $check_data->image == $model->image)?true:false;
				$flag = ($flag and $check_data->author == $model->author)?true:false;
				
				
				//если изменения произошли то выполняем сохранение данный
				//новая запись будет активной а старая отправится в историю
				if(!$flag)
				{
					$insert->save(false);
					
					if(!empty($insert->imageFile))
						   $this->saveImage($insert);
					//отправляем старую запись в историю
					$check_data->active_ver = 0;
				    $check_data->save(false);
				
				}	
				
				return $this->redirect(['view', 'id' => $model->id_book]);
				
			}
		    else
				return \yii\web\BadRequestHttpException(print_r($model->errors));
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

	public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Users();
		$model->scenario = Users::SCENARIO_LOGIN;
		
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
			
		    Yii::$app->user->login($model, 3600*24);
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
	
    public function actionRegist()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Users();
		$model->scenario = Users::SCENARIO_REGIST;
		
        if ($model->load(Yii::$app->request->post()) and $model->saveUser()) {
			
			
		    Yii::$app->user->login($model, 3600*24);
			// print_r(Yii::$app->user->identity->username);exit;
			
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    /**
     * Deletes an existing History model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id = 0)
    {
       throw new NotFoundHttpException('The requested page does not exist.');
    }

   
}
