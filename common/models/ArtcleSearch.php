<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Article;

/**
 * ArtcleSearch represents the model behind the search form of `common\models\Article`.
 */
class ArtcleSearch extends Article
{
	public function attributes()
	{
		return array_merge(parent::attributes(), ['admin_user_name']);
	}

	/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'admin_user_id', 'status_id', 'update_time'], 'integer'],
            [['title', 'content', 'tags', 'create_time', 'admin_user_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Article::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
	        'query'      => $query,
	        'pagination' => ['pageSize' => 10],
	        'sort'       => [
		        'defaultOrder' => ['article_id' => SORT_DESC],
		        'attributes'   => ['article_id', 'update_time']

	        ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'article_id' => $this->article_id,
            'admin_user_id' => $this->admin_user_id,
            'status_id' => $this->status_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
	          ->andFilterWhere(['like', 'content', $this->content])
	          ->andFilterWhere(['like', 'tags', $this->tags]);

	    $query->join('INNER JOIN', 'Admin_user', 'Article.admin_user_id = Admin_user.admin_user_id');
	    $query->andFilterWhere(['like', 'Admin_user.nick_name', $this->admin_user_name]);

	    $dataProvider->sort->attributes['admin_user_name'] = [
		    'asc'  => ['Admin_user.nick_name' => SORT_ASC],
		    'desc' => ['Admin_user.nick_name' => SORT_DESC],
	    ];

        return $dataProvider;
    }
}
