<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $tag_id
 * @property string $name 名称
 * @property int $frequency 频率
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
	        'tag_id'    => 'Tag ID',
	        'name'      => 'Name',
	        'frequency' => 'Frequency',
        ];
    }

    public static function string2array($tags)
    {
		return preg_split('/\s*,\s*/', trim($tags), -1, PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tags)
    {
		return implode(',', $tags);
    }

    public static function addTags($tags)
    {
        if (empty($tags)) return;

        foreach ($tags as $name) {
	        $tempTag      = Tag::find()->where(['name' => $name])->one();
	        $tempTagCount = Tag::find()->where(['name' => $name])->count();

	        if (!$tempTagCount) {
				$tag = new Tag;
		        $tag->name = $name;
		        $tag->frequency = 1;
		        $tag->save();
	        } else {
		        $tempTag->frequency += 1;
		        $tempTag->save();
	        }
        }
    }

    public static function removeTags($tags)
    {
    	if (empty($tags)) return;

    	foreach ($tags as $name) {
		    $tempTag      = Tag::find()->where(['name' => $name])->one();
		    $tempTagCount = Tag::find()->where(['name' => $name])->count();

		    if ($tempTagCount) {
		    	if ($tempTagCount && $tempTag->frequency <= 1) {
				    $tempTag->delete();
			    } else {
				    $tempTag->frequency -= 1;
				    $tempTag->save();
			    }
		    }
	    }
    }

    public static function updateFrequency($oldTags, $newTags)
    {
		if (!empty($oldTags) || !empty($newTags)) {
			$oldTagsArray = self::string2array($oldTags);
			$newTagsArray = self::string2array($newTags);

			$addTags    = array_values(array_diff($newTagsArray, $oldTagsArray));
			$removeTags = array_values(array_diff($oldTagsArray, $newTagsArray));

			self::addTags($addTags);
			self::removeTags($removeTags);
		}
    }
}
