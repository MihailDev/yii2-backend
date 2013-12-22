<?php


namespace app\backend;

use Yii;
use yii\base\InvalidConfigException;

/**
 * @property bool $isFrontEnd
 * @property bool $isBackEnd
 */


class Component extends \yii\base\Component{



    public $prefix = 'backend';
    public $indexAction = 'site/backend';
    public $backend = [];
    public $frontend = [];

    private $_isBackEnd = false;
    private $_backEndUrlManager;

    public function init(){
        $pos = stripos(Yii::$app->request->getAbsoluteUrl(), $this->createAbsoluteUrl($this->indexAction));
        if($pos === 0)
            $this->_isBackEnd = true;



        if($this->isBackEnd){
           $this->initBackEnd();
        }else{
            $this->initFrontEnd();
        }
    }

    private function initApp($options){
        $preload = [];
        if(isset($options['preload'])){
            $preload = $options['preload'];

            unset($options['preload']);
        }

        Yii::configure(Yii::$app, $options);

        foreach ($preload as $id) {
            if (Yii::$app->hasComponent($id)) {
                Yii::$app->getComponent($id);
            } elseif (Yii::$app->hasModule($id)) {
                Yii::$app->getModule($id);
            } else {
                throw new InvalidConfigException("Unknown component or module: $id");
            }
        }
    }

    private function initBackEnd(){
        if(!isset($this->backend['components']['view'])){
            if(isset($this->backend['theme'])){
                $this->backend['components']['view'] = [
                    'class' => 'yii\web\View',
                    'theme' => [
                        'basePath' => '@webroot/'.$this->backend['theme'],
                        'baseUrl' => '@web/'.$this->backend['theme'],
                    ],
                ];
            }else{
                $this->backend['components']['view'] = ['class' => 'yii\web\View'];
            }
        }

        unset($this->backend['theme']);

        $this->initApp($this->backend);

        Yii::$app->setComponent('urlManager', $this->getBackEndUrlManager());
    }

    private function initFrontEnd(){
        if(isset($this->frontend['theme'])){
            $this->frontend['components']['view'] = [
                'class' => 'yii\web\View',
                'theme' => [
                    'basePath' => '@webroot/'.$this->backend['theme'],
                    'baseUrl' => '@web/'.$this->backend['theme'],
                ],
            ];
        }

        unset($this->frontend['theme']);


        $this->initApp($this->frontend);
    }

    public function getIsBackEnd(){
        return $this->_isBackEnd;
    }

    public function getIsFrontEnd(){
        return (!$this->_isBackEnd);
    }

    private function getBackEndUrlManager(){
        if(null == $this->_backEndUrlManager)
            $this->_backEndUrlManager = Yii::createObject([
                'class' => 'yii\web\UrlManager',
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                    $this->prefix                               => $this->indexAction,
                    $this->prefix.'/<_m:\w+>/<_c:\w+>/<_a:\w+>' => '<_m>/<_c>/<_a>',
                    $this->prefix.'/<_c:\w+>/<_a:\w+>'          => '<_c>/<_a>',
                    $this->prefix.'/<_c:\w+>'                   => '<_c>',

                ]
            ]);

        return $this->_backEndUrlManager;
    }

    public function createUrl($route, $params = []){
        return $this->getBackEndUrlManager()->createUrl($route, $params);
    }

    public function createAbsoluteUrl($route, $params = []){
        return $this->getBackEndUrlManager()->createAbsoluteUrl($route, $params);
    }

} 