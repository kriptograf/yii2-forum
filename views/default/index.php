<?php
/**
 * Created with love.
 * User: BenasPaulikas
 * Date: 2016-03-30
 * Time: 00:56
 */

/* @var benaspaulikas\forum\models\Category[] $categories */

use benaspaulikas\forum\models\Category;
use benaspaulikas\forum\models\Post;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = Yii::t('app', 'Forum');
$this->params['breadcrumbs'][] = $this->title;


foreach ($categories as $category) {
    echo GridView::widget([
        'export' => false,
        'beforeHeader' => [
            [
                'columns' => [
                    ['content' => $category->title, 'options' => ['colspan' => 6, 'class' => 'text-center warning']],
                ],
            ]
        ],
        'dataProvider' => new ActiveDataProvider(['query' => Category::find()->where(['parent_id' => $category->id])]),
        'summary' => false,
        'beforeRow' => function ($category) {
            Yii::$app->params['category'] = Post::getPostByCategory($category)->orderBy('id DESC')->one();
        },
        'columns' => [
            [
                'attribute' => 'name',
                'label' => Yii::t('app', 'Forum'),
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->title, $model->url);
                }
            ],
            [
                'label' => Yii::t('app', 'Topics'),
                'value' => function ($category) {
                    return Post::getPostByCategory($category)->andWhere(['parent_id' => 0])->count();
                }
            ],
            [
                'label' => Yii::t('app', 'Posts'),
                'value' => function ($category) {
                    return Post::getPostByCategory($category)->andWhere(['not', ['parent_id' => 0]])->count();
                }
            ],
            [
                'label' => Yii::t('app', 'Last Post'),
                'format' => 'raw',
                'value' => function () {
                    $post = Yii::$app->params['category'];
                    if ($post) {
                        return Yii::$app->formatter->asRelativeTime(strtotime($post->date));
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'label' => '',
                'format' => 'raw',
                'value' => function () {
                    $post = Yii::$app->params['category'];
                    if ($post) {
                        $parent = $post->parent_id ? $post->parent : $post;
                        $label = Html::tag('span', Html::a(Html::encode(StringHelper::truncate($parent->subject, 40)), $parent->url, []), ['class' => 'text-highlights rounded text-highlights-green']);
                        return $label;
                    }
                    return false;
                }
            ],
            [
                'label' => '',
                'format' => 'raw',
                'value' => function () {
                    $post = Yii::$app->params['category'];
                    if ($post) {
                        $color = $post->user->id == 1 ? 'orange' : 'aqua';
                        return Html::tag('span', Html::encode($post->user->name), ['class' => 'text-highlights rounded text-highlights-' . $color]);
                    }
                    return false;
                }
            ],
        ]
    ]);
}
?>