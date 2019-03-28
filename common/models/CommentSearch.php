<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentSearch represents the model behind the search form of `common\models\Comment`.
 */
class CommentSearch extends Comment
{
	public function attributes()
	{
		return array_merge(parent::attributes(), ['user.username']);
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_id', 'status_id', 'article_id', 'user_id'], 'integer'],
            [['content', 'create_time', 'email', 'url', 'user.username'], 'safe'],
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
        $query = Comment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
	        'comment_id'  => $this->comment_id,
	        'status_id'   => $this->status_id,
	        'article_id'  => $this->article_id,
	        'user_id'     => $this->user_id,
	        'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
              ->andFilterWhere(['like', 'email', $this->email])
              ->andFilterWhere(['like', 'url', $this->url]);

        $query->join('INNER JOIN', 'user', 'comment.user_id = user.user_id');
	    $query->andFilterWhere(['like', 'user.username', $this->getAttribute('user.username')]);

	    $dataProvider->sort->attributes['username'] = [
		    'asc'  => ['user.username' => SORT_ASC],
		    'desc' => ['user.username' => SORT_DESC],
	    ];

        return $dataProvider;
    }
}
