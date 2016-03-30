<?php
/**
 * Created with love.
 * User: BenasPaulikas
 * Date: 2016-03-30
 * Time: 21:49
 */

namespace benaspaulikas\forum\controllers;


use benaspaulikas\forum\models\Category;
use benaspaulikas\forum\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    public function actionIndex($id)
    {
        /* @var $model Category */
        $model = Category::find()->where(['id' => $id])->andWhere(['>', 'parent_id', 0])->one();

        if (!$model) {
            throw new NotFoundHttpException('Category not found');
        }

        $query = Post::find()
            ->where(['category_id' => $model->id, 'parent_id' => 0])
            ->orWhere(['category_id' => $model->parent->id]);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => new ActiveDataProvider([
                'query' => $query->orderBy('id DESC')
            ])
        ]);
    }

}