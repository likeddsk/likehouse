<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $comment_id
 * @property int $status_id 状态ID
 * @property int $article_id 文章ID
 * @property int $user_id 用户ID
 * @property string $content 内容
 * @property string $create_time 添加时间
 * @property string $email 邮箱
 * @property string $url 链接
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_id', 'article_id', 'user_id', 'content', 'create_time', 'email', 'url'], 'required'],
            [['status_id', 'article_id', 'user_id'], 'integer'],
            [['content'], 'string'],
            [['create_time'], 'safe'],
            [['email', 'url'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
	        'comment_id' => 'ID',
	        'content'    => '内容',
	        'status_id'  => '状态',
	        'article_id' => '文章',
	        'user_id'    => '用户',
	        'create_time' => '创建时间',
	        'email'      => 'Email',
	        'url'        => 'Url',
        ];
    }

    public function getArticle()
    {
    	return $this->hasOne(Article::className(), ['article_id' => 'article_id']);
    }

    public function getCommentStatus()
    {
	    return $this->hasOne(Commentstatus::className(), ['status_id' => 'status_id']);
    }

	public function getUser()
	{
		return $this->hasOne(User::className(), ['user_id' => 'user_id']);
	}

    public function getBeginning()
    {
		$tempStr = strip_tags($this->content);
		$tempLen = mb_strlen($tempStr);

		return mb_substr($tempStr, 0, 20, 'utf-8') . (($tempLen > 20) ? '...' : '');
    }
}
