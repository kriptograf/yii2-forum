<?php
/**
 * Created with love.
 * User: BenasPaulikas
 * Date: 2016-03-30
 * Time: 21:52
 */

namespace benaspaulikas\forum\controllers;


use benaspaulikas\forum\models\Category;
use benaspaulikas\forum\models\Post;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        /* @var $model Post */
        $model = Post::find()->where(['id' => $id, 'parent_id' => 0])->one();
        if (!$model) throw new NotFoundHttpException('The requested post does not exist.');

        $model->views++;
        $model->save(false);

        $comment = new Post;
        $comment->parent_id = $model->id;
        $comment->category_id = $model->category_id;

        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            return $this->redirect(['/forum/post', 'id' => $model->id]);
        }

        $query = Post::find()->where(['id' => $id])->orWhere(['parent_id' => $id])->orderBy('parent_id, id ASC');

        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => $query
            ]),
            'model' => $model,
            'comment' => $comment
        ]);
    }

    public function actionCreate($category_id)
    {
        $category = Category::find()->where(['id' => $category_id])->one();
        if (!$category) throw new NotFoundHttpException('The requested page does not exist.');

        $model = new Post;
        $model->category_id = $category_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/forum/post', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'category' => $category,
        ]);
    }

    public function actionUpdate($id)
    {
        /* @var $model Post */
        $model = Post::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('The requested post does not exist.');
        } else if ($model->user_id != Yii::$app->user->id) {
            throw new HttpException('This post does not belong to you.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/forum/post', 'id' => $model->parent_id ? $model->parent_id : $model->id]);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        /* @var $model Post */
        $model = Post::findOne($id);
        if (Yii::$app->user->id == $model->user_id) {
            $model->delete();
            if ($model->parent_id) {
                return $this->redirect(['/forum/post', 'id' => $model->parent_id]);
            }
        }
        return $this->redirect(['/forum/']);
    }

}
