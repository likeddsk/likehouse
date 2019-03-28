<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_user".
 *
 * @property int $admin_user_id
 * @property string $user_name 名称
 * @property string $nick_name 昵称
 * @property string $password 密码
 * @property string $email 邮箱
 * @property string $profile 配置文件
 */
class AdminUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_name', 'password', 'email'], 'required'],
            [['profile'], 'string'],
            [['user_name', 'nick_name', 'password', 'email'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'admin_user_id' => 'User ID',
            'user_name' => 'User Name',
            'nick_name' => 'Nick Name',
            'password' => 'Password',
            'email' => 'Email',
            'profile' => 'Profile',
        ];
    }
}
