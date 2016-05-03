yii2-backend
============

The Backend extension for the Yii2 framework

Config file.
```php
        'preload'=>['backend'],
        ...
        'components' => [
        ...
                'backend' => [
                        'class' => 'mihaildev\backend\Component',
                        
                        'onBackend' => function(){
                                Yii::$app->user->loginUrl = ['/backend/login'];
                        },
                        'onFrontend' => function(){
                                Yii::$app->user->loginUrl = ['/site/login'];
                        },
                
                
                ],
          ...
          ]

```

Controller (only for backend)
```php
class SomeController extends Controller implements BackendControllerInterface{

}
```

