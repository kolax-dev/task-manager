<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;
use app\models\Tasks;
use app\models\Projects;

class SiteController extends Controller
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


    public function actionIndex()
    {
      if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/login');
        }
        $user_id = Yii::$app->user->getID();
        $username = Yii::$app->user->identity->username;
        $projects =  Projects::find()
        ->where(['user_id'=>$user_id])
        ->orderBy('id')
        ->all();
        return $this->render('index',[
          'projects'=>$projects,
          'username'=>$username,
        ]);
    }

    public function actionEditTask()
    {
      if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

             $id_task = Yii::$app->request->post('id_task');
             $name_task = Yii::$app->request->post('name_task');
             $status_task = Yii::$app->request->post('status_task');
             $deadline = Yii::$app->request->post('deadline');
             $mess = '';
             if(empty($name_task)){$mess = 'Поле должно быть заполнено';}
             if(empty($mess)){
                 $model = Tasks::findOne(['id'=>$id_task]);
                 $model->name = $name_task;
                 $model->status = $status_task;
                 $model->deadline = $deadline;
                 $model->save();
                 $color = $model->getColor($model->status);
                 $deadline = Yii::$app->formatter->asDatetime($model->deadline, "php:d.m.Y");
             Yii::$app->response->format = Response::FORMAT_JSON;
             return [
               'model' => $model,
               'color' => $color,
               'deadline' =>$deadline
             ];

         }  else {
             Yii::$app->response->format = Response::FORMAT_JSON;
             return ['mess'=>$mess];
           }
         return false;
    }
  }

    public function actionDelTask()
    {
      if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

             $id_task = Yii::$app->request->post('id');

                 $model = Tasks::findOne(['id'=>$id_task]);
                 if($model){
                   $model->delete();
                 }
             return true;
         }
         return false;
    }

    public function actionAddTask()
    {
      if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $id_project = Yii::$app->request->post('id_project');
            $name_task = Yii::$app->request->post('name_task');
            $mess = '';
            if(empty($name_task)){$mess = 'Поле должно быть заполнено';}
            if(empty($mess)){
              $model = new Tasks();
              $model->id_project = $id_project;
              $model->name = $name_task;
              $model->save();
              $color = $model->getColor($model->status);
              Yii::$app->response->format = Response::FORMAT_JSON;
              return [
                'color'=>$color,
                'model'=>$model
              ];
            } else {
              Yii::$app->response->format = Response::FORMAT_JSON;
              return ['mess'=>$mess];
            }

         }
         return false;
    }

    public function actionAddProject()
    {
      if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $user_id = Yii::$app->request->post('user_id');
            $name_project = Yii::$app->request->post('name_project');
            $mess = '';
            if(empty($name_project)){$mess = 'Поле должно быть заполнено';}
            if(empty($mess)){
              $model = new Projects();
              $model->user_id = $user_id;
              $model->name = $name_project;
              $model->save();
              return true;
            } else {
              Yii::$app->response->format = Response::FORMAT_JSON;
              return ['mess'=>$mess];
            }

         }
         return false;
    }

    public function actionDelProj()
    {
      if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

             $id_project = Yii::$app->request->post('id_project');

                 $model_project = Projects::findOne(['id'=>$id_project]);
                 if($model_project){
                   $model_project->delete();
                 }
                 $model_tasks = Tasks::DeleteAll(['id_project'=>$id_project]);

             return true;
         }
         return false;
    }

    public function actionEditProj()
    {
      if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

             $id_project = Yii::$app->request->post('id_project');
             $name_project = Yii::$app->request->post('name_project');

                 $model = Projects::findOne(['id'=>$id_project]);
                 $model->name = $name_project;
                 $model->save();

             Yii::$app->response->format = Response::FORMAT_JSON;
             return ['model' => $model];

         }
         return false;
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    // public function actionContact()
    // {
    //
    //      if (Yii::$app->user->isGuest) {
    //         return $this->goHome();
    //     }
    //
    //     $model = new ContactForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
    //         Yii::$app->session->setFlash('contactFormSubmitted');
    //
    //         return $this->refresh();
    //     }
    //     return $this->render('contact', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Displays about page.
     *
     * @return string
     */
    // public function actionAbout()
    // {
    //     return $this->render('about');
    // }
}
