<?php

namespace app\controllers;

use app\models\Phone;
use app\models\User;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class UserController extends ActiveController
{
    public $modelClass = User::class;
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => [
                    'index',
                    'view',
                    'create',
                    'update',
                    'delete',
                    'add-phone',
                    'remove-phone',
                ],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add-phone' => ['POST'],
                    'remove-phone' => ['DELETE'],
                ],
            ],
        ];
    }
    
    /**
     * @return User|array|null
     */
    public function actionAddPhone()
    {
        $phone = new Phone();
        $phone->phone = Yii::$app->request->post('phone');
        $response = Yii::$app->getResponse();
        if ($phone->validate()) {
            $user = User::findOne(Yii::$app->request->post('user_id'));
            $phone->link('user', $user);
            $response->setStatusCode(201);
            $id = implode(',', array_values($user->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
            $user->touch('updated_at');
            
            return $user;
        }
        
        $response->setStatusCode(422);
        
        return $this->prepareErrorResponce($phone->getErrors());
    }
    
    /**
     * @param $id
     * @throws ServerErrorHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemovePhone($id)
    {
        $phone = Phone::findOne($id);
        $user = $phone->user;
        if ($phone->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
        $user->touch('updated_at');
        
        Yii::$app->getResponse()->setStatusCode(204);
    }
    
    /**
     * @param array $errors
     * @return array
     */
    private function prepareErrorResponce(array $errors)
    {
        $prepareErrors = [];
        foreach ($errors as $field => $error) {
            $prepareErrors['field'] = $field;
            $prepareErrors['message'] = $error[0];
        }
        
        return $prepareErrors;
    }
}