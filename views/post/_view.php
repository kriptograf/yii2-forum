<?php
/**
 * Created with love.
 * User: BenasPaulikas
 * Date: 2016-03-30
 * Time: 22:00
 */

use yii\helpers\Html;

/* @var $model benaspaulikas\forum\models\Post */

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <i class="fa fa-user"></i>
            <?= Yii::$app->user->can('admin') || Yii::$app->user->can('manager') ? Html::a($model->user->name, ['/user/view', 'id' => $model->user->id]) : $model->user->name ?>
            - <?= $model->date ?>
            (<?= Yii::$app->formatter->asRelativeTime(strtotime($model->date)) ?>)
			<span class="pull-right">
			<?php
            if (Yii::$app->user->id == $model->user_id) {
                echo Html::a('<i class="fa fa-edit"></i>', ['/forum/post/update', 'id' => $model->id]);
            }
            ?>
			</span>
        </h3>
    </div>
    <div class="panel-body">
        <?= $model->safeContent ?>
    </div>
</div>