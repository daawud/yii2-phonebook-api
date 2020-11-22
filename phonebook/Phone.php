<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "phones".
 *
 * @property int $id
 * @property string $phone
 * @property int $user_id
 *
 * @property User $user
 */
class Phone extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phones';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['user_id'], 'integer'],
            [['phone'], 'unique', 'message' => 'This phone number already exists'],
            [
                ['phone'],
                'match',
                'pattern' => '/^7\d{10}$/',
                'message' => 'Phone, must be 11 digits long and start with 7'
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Номер',
            'user_id' => 'ID владельца',
        ];
    }
    
    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
