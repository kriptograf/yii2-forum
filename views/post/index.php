<?php
/**
 * Created with love.
 * User: BenasPaulikas
 * Date: 2016-03-30
 * Time: 22:01
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $model benaspaulikas\forum\models\Post */
/* @var $comment benaspaulikas\forum\models\Post */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = HtmlPurifier::process($model->subject);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forum'), 'url' => ['/forum']];
$this->params['breadcrumbs'][] = ['label' => $model->category->title, 'url' => ['/forum/category', 'id' => $model->category->id]];
$this->params['breadcrumbs'][] = $this->title;

echo ListView::widget([
    'id' => 'post-list',
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
]);

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-comment"></i> <?= Yii::t('app', 'Comment') ?></h3>
    </div>
    <div class="panel-body"><?php
        if (!Yii::$app->user->isGuest) {
            echo $this->render('_form', ['model' => $comment, 'comment' => true]);
        } else {
            $message = Yii::t('app', 'To comment you need to {login} or {register} first.', ['login' => Html::a(Yii::t('app', 'login'), ['/user/login', 'return' => Url::to()]), 'register' => Html::a(Yii::t('app', 'register'), ['/user/register', 'return' => Url::to()])]);
            echo Html::tag('div', $message, [
                'class' => 'alert alert-info',
                'style' => 'margin-bottom:0px',
            ]);
        }
        ?>
    </div>
</div>
<?php
$this->registerJs(<<<JS
$(document).on("click", "[data-trigger=delete]", function(e){
	var self = $(this);
	e.preventDefault();
	$.ajax({
		url: $(this).attr("href"),
		success: function(data){
			self.closest("[data-key]").remove();
		}
	})
});
JS
);
?>
<style>
    .panel-body p:last-child {
        margin-bottom: 0;
    }
</style>
