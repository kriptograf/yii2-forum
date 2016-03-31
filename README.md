# yii2-forum
@TODO:
*Admin interface*
This is a simple Yii2 forum module. Logged in users can create posts and comment in forum categories.

If you have questions drop me a message at benas@paulikas.eu or skype: benas.paulikas

### 1. Download

Yii2-forum can be installed using composer. Run following command to download and install Yii2-forum:

```bash
composer require "benaspaulikas/yii2-forum:*"
```

### 2. Configure

Add following lines to your main configuration file:

```php
'forum' => [
    'class' => 'benaspaulikas\forum\Module',
        'modelMap' => [
            'User' => 'common\models\User'
        ],
    ]
]
```

### 3. Update database schema

```bash
$ php yii migrate/up --migrationPath=@vendor/benaspaulikas/yii2-forum/migrations
```