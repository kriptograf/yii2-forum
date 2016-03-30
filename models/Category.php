<?php
/**
 * Created with love.
 * User: BenasPaulikas
 * Date: 2016-03-30
 * Time: 00:54
 */

namespace benaspaulikas\forum\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "forum_category".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property Category $parent
 */
class Category extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['title', 'description'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    public function getUrl()
    {
        return ['/forum/category', 'id' => $this->id, 'title' => $this->title];
    }
}
