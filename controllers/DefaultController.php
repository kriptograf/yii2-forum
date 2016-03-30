<?php
/**
 * Created with love.
 * User: BenasPaulikas
 * Date: 2016-03-30
 * Time: 00:51
 */

namespace benaspaulikas\forum\controllers;


use benaspaulikas\forum\models\Category;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $categories = Category::find()
            ->where(['parent_id' => 0])
            ->all();

        return $this->render('index', [
            'categories' => $categories
        ]);
    }

}