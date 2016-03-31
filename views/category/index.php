<?php
/**
 * Created with love.
 * User: BenasPaulikas
 * Date: 2016-03-30
 * Time: 21:51
 */

use benaspaulikas\forum\models\Post;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $model benaspaulikas\forum\models\Category */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forum'), 'url' => ['/forum']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::a(Yii::t('app', 'Create Topic'), ['/forum/post/create', 'category_id' => $model->id], ['class' => 'btn btn-success pull-right']) ?>
    <br/><br/>
<?php
echo GridView::widget([
    'export' => false,
    'beforeHeader' => [
        [
            'columns' => [
                ['content' => $model->title . ($model->description ? Html::tag('p', $model->description, ['class' => 'forum-description']) : null), 'options' => ['colspan' => 5, 'class' => 'text-center warning']],
            ],
        ]
    ],
    'dataProvider' => $dataProvider,
    'summary' => false,
    'columns' => [
        [
            'label' => Yii::t('app', 'Topic'),
            'format' => 'raw',
            'value' => function ($model) {
                $return = '';
                $return .= Html::a(Html::encode($model->subject), $model->url);
                return $return;
            }
        ],
        [
            'label' => Yii::t('app', 'Author'),
            'value' => function ($model) {
                return $model->user->name;
            }
        ],
        [
            'attribute' => 'views',
        ],
        [
            'attribute' => Yii::t('app', 'Comments'),
            'value' => function ($model) {
                return Post::find()->where(['parent_id' => $model->id])->count();
            }
        ],
        [
            'label' => Yii::t('app', 'Last message'),
            'format' => 'raw',
            'value' => function ($model) {
                $post = Post::find()->where(['parent_id' => $model->id])->orWhere(['id' => $model->id])->orderBy('id DESC')->one();
                return $post->date . '<br/>' . $post->user->name;
            }
        ],

    ]
]);
?>