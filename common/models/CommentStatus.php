<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment_status".
 *
 * @property int $status_id
 * @property string $name 名称
 * @property int $position 位置
 */
class CommentStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment_status';
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
