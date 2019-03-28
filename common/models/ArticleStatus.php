<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article_status".
 *
 * @property int $status_id
 * @property string $name 状态名称
 * @property int $position 位置
 */
class ArticleStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['position'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'Status ID',
            'name' => 'Name',
            'position' => 'Position',
        ];
    }
}
