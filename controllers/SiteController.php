<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Test;
use yii\data\Pagination;
use app\models\EntryForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionDemo()
    {  
        return $this->render('demo');
    }
    public function actionEntryform()
    {
        $model = new EntryForm;
        $val = ['name'=>'','writer'=>'','id'=>''];
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // 验证 $model 收到的数据
            // 做些有意义的事 ...
            $sql = "insert into `books` (`name`,`writer`) values ('".$model->name."','".$model->writer."')";
            Yii::$app->db->createCommand($sql)->execute();
            return $this->render('demo',['sql'=>$sql]);
            
        } else {
            // 无论是初始化显示还是数据验证错误
            return $this->render('entryform', ['model' => $model,'val' => $val]);
        }
    }
    public function actionDelete($id)
    {
        if($id) {
            $sql = "delete from books where id = '".$id."';";
            Yii::$app->db->createCommand($sql)->execute();

            return $this->render('demo');
        }else{

        }
    }
    public function actionUpdate($id)
    {
        $model = new EntryForm;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $sql = "update `books` set `name`='".$model->name."',`writer`='".$model->writer."' where `id` = '".$id."'";
            Yii::$app->db->createCommand($sql)->execute();
            // Yii::$app->db->createCommand()->update('books', ['name' => $model->name,'writer' => $model->writer], "id='".$model->id."'")->execute(); 
            return $this->render('demo');
        }else if($id) {
            $sql = "select * from `books` where id = '".$id."';";
            $val = Yii::$app->db->createCommand($sql)->queryOne(); 
            return $this->render('updateform',[
                'val' => $val,
                'model' => $model
            ]);
        }
    }
    public function actionUpdateform($id)
    {
        if($id) {
            $sql = "select * from `books` where id = '".$id."';";
            $val = Yii::$app->db->createCommand($sql)->queryOne(); 
            var_dump($val);
            return $this->render('updateform',[
                'val' => $val
            ]);
        }else{

        }
    }
}
