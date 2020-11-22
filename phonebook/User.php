<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $firstname
 * @property string $secondname
 * @property string $lastname
 * @property int|null $updated
 *
 * @property Phone[] $phones
 */
class User extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'second_name', 'last_name'], 'required'],
            [['updated_at'], 'integer'],
            [['first_name', 'second_name', 'last_name'], 'string', 'max' => 255],
            [
                ['first_name', 'second_name', 'last_name'],
                'unique',
                'targetAttribute' => ['first_name', 'second_name', 'last_name'],
                'message' => 'The combination of first_name, second_name and last_name has already been given.'
            ],
        ];
    }
    
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'first_name',
            'second_name',
            'last_name',
            'updated_at' => function ($model) {
                return Yii::$app->formatter->asDate($model->updated_at, 'dd.MM.yyyy');
            },
            'phones' => function ($model) {
                return $model->phones;
            }
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Имя',
            'second_name' => 'Фамилия',
            'last_name' => 'Отчество',
            'updated_at' => 'Дата обновления',
        ];
    }
    
    /**
     * Gets query for [[Phone]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhones()
    {
        return $this->hasMany(Phone::class, ['user_id' => 'id']);
    }
}
