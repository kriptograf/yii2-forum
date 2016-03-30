<?php
/**
 * Created with love.
 * User: BenasPaulikas
 * Date: 2016-03-30
 * Time: 21:59
 */

use yii\helpers\Html;
use yii\imperavi\Widget;
use yii\widgets\ActiveForm;

/* @var $model benaspaulikas\forum\models\Post */

$form = ActiveForm::begin();
echo $form->errorSummary($model);
if (!isset($comment)) echo $form->field($model, 'subject')->textInput(['maxlength' => 100]);
$buttons = ['formatting', 'bold', 'italic', 'deleted', 'link', 'orderedlist', 'paragraph'];

echo Widget::widget([
    'model' => $model,
    'attribute' => 'content',
    'options' => [
        'imageUpload' => false,
        'buttons' => $buttons,
        'formatting' => ['p', 'blockquote', 'pre'],
    ],
]);
echo Html::submitButton($model->isNewRecord ? Yii::t('app', isset($comment) ? 'Reply' : 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-u' : 'btn btn-u']);
ActiveForm::end();