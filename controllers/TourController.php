<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;

class TourController extends Controller
{
    protected $tours;

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

    public function init()
    {
        $this->tours = [
            1464 => [
                'from' => 'Rostov',
                'to' => 'Cyprus',
                'date' => '2021-02-14',
                'days' => 7
            ],
            2351 => [
                'from' => 'Saint Petersburg',
                'to' => 'Rostov',
                'date' => '2021-04-11',
                'days' => 2
            ],
            5423 => [
                'from' => 'Moscow',
                'to' => 'San Francisco',
                'date' => '2021-02-29',
                'days' => 29
            ]
        ];
        parent::init();
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

    public function actionList()
    {
        return $this->tours;
    }

    public function actionView($tourId)
    {
        if (isset($this->tours[$tourId])) {
            return $this->tours[$tourId];
        }
        throw new NotFoundHttpException(
            'Тур с таким идентификатором не найден',
            404
        );
    }

    public function actionCreate()
    {
        $request = \Yii::$app->request;
        $apiFields  = $request->post();
        if ($request->isPost && $this->validateTour($apiFields)) {
            return [
                'success' => true,
                'newTourData' => [
                    'from' => $apiFields['from'],
                    'to' => $apiFields['to'],
                    'date' => $apiFields['date'],
                    'days' => $apiFields['days'] ?? '',
                ]
            ];
        }
        throw new MethodNotAllowedHttpException();
    }

    protected function validateTour(array $apiFields)
    {
        $requiredFields = [
            'from',
            'to',
            'date',
        ];
        foreach ($requiredFields as $requiredField) {
            if (!isset($apiFields[$requiredField])) {
                throw new BadRequestHttpException("`".ucfirst($requiredField) . '` field is required');
            }
        }
        return true;
    }
}
