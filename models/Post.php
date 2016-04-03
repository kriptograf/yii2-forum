<?php
/**
 * Created with love.
 * User: BenasPaulikas
 * Date: 2016-03-30
 * Time: 21:40
 */

namespace benaspaulikas\forum\models;

use Yii;
use yii\db\ActiveRecord;


/**
 * Class Post
 * @package benaspaulikas\forum\models
 * @property object User
 * @property integer $id
 * @property integer $user_id
 * @property integer $parent_id
 * @property integer $category_id
 * @property string $date
 * @proprety string $views
 * @property string $subject
 * @property string $safeContent
 */
class Post extends ActiveRecord
{

    public $language_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_post';
    }

    /**
     * @param $category
     * @return \yii\db\ActiveQuery
     */
    public static function getPostByCategory($category)
    {
        $model = $category;
        return self::find()->where(['category_id' => $model->id]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['category_id'], 'integer'],
            [['content'], 'string'],
            [['subject'], 'string', 'max' => 100],
            [['category_id', 'parent_id'], 'safe'],//@TODO caution, used to move post
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $array = [
            'id' => Yii::t('app', 'ID'),
            'subject' => Yii::t('app', 'Subject'),
            'content' => Yii::t('app', 'Content'),
            'views' => Yii::t('app', 'Views'),
            'category' => Yii::t('app', 'Category')
        ];

        if (!$this->category_id) {
            $array['content'] = Yii::t('app', 'Comment');
        }

        return $array;
    }

    public function getUser()
    {
        return $this->hasOne(Yii::$app->getModule('forum')->modelMap['User'], ['id' => 'user_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getParent()
    {
        return $this->hasOne(Post::className(), ['id' => 'parent_id']);
    }

    public function getChilds()
    {
        return $this->hasMany(Post::className(), ['parent_id' => 'id']);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->parent_id == 0) {
                Post::deleteAll(['parent_id' => $this->id]);
            }
            return true;
        } else {
            return false;
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->user_id = Yii::$app->user->id;
                $this->date = date("Y-m-d H:i:s");
            }
            return true;
        } else {
            return false;
        }
    }

    public function getSafeContent()
    {
        return \yii\helpers\HtmlPurifier::process(preg_replace("/(<p><br><\/p>)+$/m", "$2", $this->content), [
            'HTML.TargetBlank' => true
        ]);
    }

    public function getUrl()
    {
        return ['/forum/post', 'id' => $this->id, 'title' => $this->subject];
    }

}

