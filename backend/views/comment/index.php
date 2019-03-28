<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommentStatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
	    'dataProvider' => $dataProvider,
	    'filterModel'  => $searchModel,
	    'columns'      => [
	        [
		        'attribute'      => 'comment_id',
		        'contentOptions' => ['width' => '30px']
			],
	        [
		        'attribute' => 'content',
		        'value'     => 'beginning'
//		        'value'     => function ($model) {
//			        $tempStr = strip_tags($model->content);
//			        $tempLen = mb_strlen($tempStr);
//
//			        return mb_substr($tempStr, 0, 20, 'utf-8') . (($tempLen > 20) ? '...' : '');
//		        }
	        ],
            [
	            'attribute' => 'user.username',
	            'label'     => '用户',
	            'value'     => 'user.username',
			],
            [
	            'attribute' => 'status_id',
	            'value'     => 'commentStatus.name',
	            'filter'    => CommentStatus::find()
							-> select(['name', 'status_id'])
							-> orderBy('position')
							-> indexBy('status_id')
							-> column()
			],
            'article.title',
		    [
			    'attribute' => 'create_time',
			    'format'    => ['date', 'php:m-d H:i']
		    ],
            //'email:email',
            //'url:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
