<?php


namespace mihaildev\backend;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * @property bool $isBackEnd
 */


class Component extends \yii\base\Component implements BootstrapInterface{

    const EVENT_BACKEND_INIT  = 'EVENT_BACKEND_INIT';
    const EVENT_FRONTEND_INIT = 'EVENT_FRONTEND_INIT';

    public $onBackend;

    public $onFrontend;


    public function init(){

    }

    private $_isBackEnd;

    public function getIsBackEnd(){
        return $this->_isBackEnd;
    }

    static function detectBackend(){
        /** @var Component $backend */
        $backend = Yii::$app->get('backend');

        if(Yii::$app->controller instanceof BackendControllerInterface)
            $backend->initBackend();
        else
            $backend->initFronted();
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if(!($app instanceof \yii\web\Application))
            return;

        if(!$app->has('backend'))
            $app->set('backend', static::className());

        if($app->get('backend') instanceof Component)
            $app->on(\yii\web\Application::EVENT_BEFORE_ACTION,[self::className(), 'detectBackend']);
    }

    public function initBackend()
    {
        $this->_isBackEnd = true;

        if(is_callable($this->onBackend))
            call_user_func($this->onBackend);

        $this->trigger(self::EVENT_BACKEND_INIT);

    }

    public function initFronted()
    {
        $this->_isBackEnd = false;

        if(is_callable($this->onFrontend))
            call_user_func($this->onFrontend);

        $this->trigger(self::EVENT_FRONTEND_INIT);

    }
}