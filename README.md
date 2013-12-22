yii2-backend
============

The Backend extension for the Yii2 framework
        
        'preload'=>['backend'],
        ...
        'components' => [
        ...
            'backend' => [
                'class' => 'app\backend\Component',
    
                'prefix' => 'backend',/*'prefix' => 'http://backend.domain.ru',*/
                'indexAction' => 'site/backend',
    
                'backend' => [
                    'name' => 'backend',
                    'theme' => 'themes/test'
                ],
    
                'frontend' => [],
    
                'console' => [],
            ],
          ...
          ]
