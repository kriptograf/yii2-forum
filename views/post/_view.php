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
            <?= $model->date ?>
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
        <div class="row">
            <div class="col-md-2">
                <?= Html::tag('p', $model->user->username, [
                    'style' => 'overflow:hidden'
                ]) ?>
                <?php if (Yii::$app->modules['forum']->userInfo): ?>
                    <?= call_user_func(Yii::$app->modules['forum']->userInfo, $model) ?>
                <?php endif ?>

            </div>
            <div class="col-md-10">
                <?= $model->safeContent ?>
            </div>
        </div>

    </div>
</div>
