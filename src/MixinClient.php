<?php

namespace ExinOne\MixinSDK;

use ExinOne\MixinSDK\Exceptions\ClassNotFoundException;
use ExinOne\MixinSDK\Exceptions\MixinNetworkRequestException;
use ExinOne\MixinSDK\Exceptions\NotFoundConfigException;
use ExinOne\MixinSDK\Facades\MixinSDK;

/**
 * @method  Container user()
 * @method  Container pin()
 * @method  Container network()
 * @method  Container wallet()
 *
 * @see \ExinOne\MixinSDK\MixinClient
 */
class MixinClient
{
    /**
     */
    public $config;

    protected $useConfigName = 'default';

    /**
     * @var bool
     */
    public $raw = false;

    /**
     * MixinSDK constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->useConfigName = 'default';
        if (! empty($config)) {
            $this->config[$this->useConfigName] = $config;
        } else {
            $this->config = config('mixin_sdk.keys', []);
        }
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return \ExinOne\MixinSDK\Container
     * @throws \ExinOne\MixinSDK\Exceptions\ClassNotFoundException
     * @throws \ExinOne\MixinSDK\Exceptions\MixinNetworkRequestException
     */
    public function __call($name, $arguments)
    {
        $useConfigName = $this->useConfigName;
        $this->useConfigName = 'default';

        $name  = ucfirst($name);
        $class = __NAMESPACE__.'\\Apis\\'.$name;
        // 作为包的入口， 根据 $name 返回相应的实例
        if (class_exists($class)) {
            return (new Container())
                ->setDetailClass(new $class($this->config[$useConfigName]));
        } else {
            throw new ClassNotFoundException("class \"$name\" not found, pleace check className");
        }
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        throw new \Exception('please use MixinClient Facade class');
    }

    /**
     * @param       $name
     * @param array $config
     *
     * @return $this
     */
    public function use(string $name, array $config = [])
    {
        $this->useConfigName = $name;
        if (! empty($config)) {
            $this->config[$name] = $config;
        }

        return $this;
    }

    /**
     * @param string $name
     * @param array  $config
     *
     * @return $this
     */
    public function setConfig(string $name, array $config)
    {
        $this->config[$name] = $config;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \ExinOne\MixinSDK\Exceptions\NotFoundConfigException
     */
    public function getConfig(string $name = '')
    {
        if ($name != '') {
            if (in_array($name, array_keys($this->config))) {
                return $this->config[$name];
            }
            throw new NotFoundConfigException('config not found');
        }

        return $this->config;
    }

    /**
     * 获取该单例实例 句柄
     *
     * @return $this
     */
    public function get()
    {
        return $this;
    }

    /**
     * @param $client_id
     * @param $scope
     *
     * @return string
     */
    public function getOauthUrl($client_id, string $scope)
    {
        return "https://mixin.one/oauth/authorize?client_id=$client_id&scope=$scope&response_type=code";
    }
}
