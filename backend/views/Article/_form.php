<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ArticleStatus;
use common\models\AdminUser;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'content')->textarea(['rows' => 18]) ?>

	<?= $form->field($model, 'tags')->textarea(['rows' => 3]) ?>

	<?php
	$allAdminUser = AdminUser::find()
				  ->select(['nick_name', 'admin_user_id'])
				  ->indexBy('admin_user_id')   // status_id为键
			  	  ->column(); // 取值的第一列
	?>

	<?=
		$form->field($model, 'admin_user_id')->dropDownList($allAdminUser, ['prompt' => '请选择状态'])
	?>

	<?php
	/*  第一种
		$articleStatusObjs = ArticleStatus::find()->all();
		$allStatus         = ArrayHelper::map($psObjs, 'status_id', 'name')

		第二种
		$articleStatusArray = Yii::$app->db->createCommand('select * from article_status')->queryAll();
		$allStatus          = ArrayHelper::map($articleStatusArray, 'status_id', 'name')

		第三种
		$allStatus = (new \yii\db\Query())
				   ->select(['name', 'status_id'])
				   ->from('article_status')
				   ->indexBy('status_id')   // status_id为键
				   ->column(); // 取值的第一列
	*/

	$allStatus = ArticleStatus::find()
			   ->select(['name', 'status_id'])
			   ->orderBy('position')
			   ->indexBy('status_id')   // status_id为键
			   ->column(); // 取值的第一列
	?>

	<?=
		$form->field($model, 'status_id')->dropDownList($allStatus, ['prompt' => '请选择状态'])
	?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
