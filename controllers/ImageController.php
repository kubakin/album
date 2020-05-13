<?php

namespace app\controllers;

use Yii;
use app\models\LoginForm;
use app\models\Images;
use app\models\ImagesSearch;
use app\models\UploadForm;
use app\models\User;
use yii\base\View;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use function GuzzleHttp\Psr7\str;

/**
 * ImageController implements the CRUD actions for Images model.
 */
class ImageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','delete','update','uploads'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view','delete','update','uploads'],
                        'allow' => true,
                        //'roles' => ['@'],
                        'matchCallback'=> function($rule, $action){
                           return  Yii::$app->getUser()->identity->login == Images::findOne(Yii::$app->request->queryParams)->whoadd;
                           // die(var_dump());
                            //die(var_dump(Images::findOne(Yii::$app->request->queryParams)->whoadd));
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Images models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Images model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
 
        return $this->render('view', [
            'model' => $this->findModel($id),
  
        ]);
    }
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //die(var_dump($model));
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Images model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $papka = Yii::$app->user->id;
        //die($papka);
        if (!is_dir("uploads/$papka")) {
        mkdir("uploads/$papka");
        }
        //die(var_dump(Yii::$app->getUser()));
        $model1 = new UploadForm();

        if (Yii::$app->request->isPost) {
            $filename = uniqid();
            $model1->imageFile = UploadedFile::getInstance($model1, 'imageFile');
            if ($model1->upload($papka,$filename)) {
                // file is uploaded successfully
                //return;
               $imgname = $model1['imageFile'];
            }
            
        }
        $model = new Images();

        if ($model->load(Yii::$app->request->post())) {
            
            $model['path'] = Yii::$app->urlManager->createUrl('uploads').'/'.$papka.'/'.$filename;
            $model['whoadd'] = $papka;
            $model['picname'] = $filename.'.'.$model1->imageFile->extension;
            $model->save();
           // die(var_dump($model));
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('create', [
            'model' => $model,
            'model1' => $model1
        ]);
    }
    
    /**
     * Updates an existing Images model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Images model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
        $model = $this->findModel($id);
        
        return $this-> render('delete', [
            'model' => $model,
        ]);

       // 
    }
    public function actionDeletesure($id)
    {
        unlink('uploads'.'/'.$this->findModel($id)->whoadd.'/'.$this->findModel($id)->picname);        
        $this->findModel($id)->delete();
        

        return $this->redirect(['index']);
    }
  
    /**
     * Finds the Images model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Images the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Images::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
