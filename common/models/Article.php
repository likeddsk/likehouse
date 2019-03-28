<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $article_id
 * @property int $admin_user_id 作者ID
 * @property int $status_id 状态ID
 * @property string $title 标题
 * @property string $content 内容
 * @property string $tags 标签
 * @property string $create_time 添加时间
 * @property string $update_time 修改时间
 */
class Article extends \yii\db\ActiveRecord
{
	private $_oldTags;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
	        [['admin_user_id', 'status_id', 'title', 'content'], 'required'],
	        [['admin_user_id', 'status_id'], 'integer'],
	        [['content', 'tags'], 'string'],
//	        [['create_time', 'update_time'], 'datetime'],
	        [['title'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
	        'article_id'    => 'ID',
	        'admin_user_id' => '作者',
	        'status_id'     => '状态',
	        'title'         => '标题',
	        'content'       => '内容',
	        'tags'          => '标签',
	        'create_time'   => '创建时间',
	        'update_time'   => '修改时间',
        ];
    }

	public function getComment()
	{
		return $this->hasMany(Comment::className(), ['article_id' => 'article_id']);
	}

	public function getAuthor()
	{
		return $this->hasOne(Adminuser::className(), ['admin_user_id' => 'admin_user_id']);
	}

	public function getArticleStatus()
	{
		return $this->hasOne(Articlestatus::className(), ['status_id' => 'status_id']);
	}

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($insert) {
				$this->create_time = date('Y-m-d H:i:s');
				$this->update_time = date('Y-m-d H:i:s');
			} else {
				$this->update_time = date('Y-m-d H:i:s');
			}
			return true;
		}

		return false;
	}

	public function afterFind()
	{
		parent::afterFind(); // TODO: Change the autogenerated stub
		$this->_oldTags = $this->tags;
	}

	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
		Tag::updateFrequency($this->_oldTags, $this->tags);
	}

	public function afterDelete()
	{
		parent::afterDelete(); // TODO: Change the autogenerated stub
		Tag::updateFrequency($this->tags, '');
	}
}