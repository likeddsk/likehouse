<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\ArticleStatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArtcleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
	            'attribute'      => 'article_id',
	            'contentOptions' => ['width' => '30px']
			],
	        'title',
	        [
		        'attribute'      => 'admin_user_name',
		        'value'          => 'author.nick_name',
		        'label'			 => '作者',
		        'contentOptions' => ['width' => '150px']
	        ],
	        [
		        'attribute' => 'status_id',
		        'value'     => 'articleStatus.name',
		        'filter'    => ArticleStatus::find()
			        -> select(['name', 'status_id'])
			        -> orderBy('position')
			        -> indexBy('status_id')
			        -> column(),
		        'contentOptions' => ['width' => '120px']
	        ],
            [
	            'attribute'      => 'update_time',
	            'contentOptions' => ['width' => '150px']
			],
            [
	            'class'          => 'yii\grid\ActionColumn',
	            'contentOptions' => ['width' => '70px']
			],
        ],
    ]); ?>


</div>
