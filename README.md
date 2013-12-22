yii2-backend
============

The Backend extension for the Yii2 framework

Config file.
        
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
                                'preload'=>['some'],
                        ],
                        
                        'frontend' => [
                                'name' => 'frontend',
                                'preload'=>['some2'],
                        ],
                
                
                ],
          ...
          ]
