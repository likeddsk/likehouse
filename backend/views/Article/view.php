<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->article_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->article_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定删除此文章吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           [
	           'label' => '编号',
	           'value' => $model->article_id
		   ],
           [
	           'attribute' => 'admin_user_id',
	           'value'     => $model->author->nick_name,
		   ],
           [
	           'label' => '状态',
	           'value' => $model->articleStatus->name,
		   ],
            'title',
            'content:ntext',
            'tags:ntext',
	        'create_time',
            'update_time',
        ],
        'template' => '<tr><th style="width:100px;text-align:center;letter-spacing:5px;">{label}</th><td>{value}</td></tr>',
        'options' => ['class' => 'table table-striped table-bordered detail-view']
    ]) ?>

</div>
