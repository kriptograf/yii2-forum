<?php
/**
 * Created with love.
 * User: BenasPaulikas
 * Date: 2016-03-30
 * Time: 00:51
 */

namespace benaspaulikas\forum;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public $modelMap;

    /**
     * @var Callback for rendering user information
     */
    public $userInfo;

    public function init()
    {
        parent::init();
        \Yii::configure($this, require(__DIR__ . '/config.php'));
    }
}