<?php


namespace app\index\service\cache;


use library\exception\ParameterException;

class RedisHandle
{
    private $redis;

    /** redis最大超时时间 */
    const REDIS_CONNECT_TIME_OUT = 2;

    private static $instance = null;

    public function __construct()
    {
        try
        {
            $redis = new \Redis();
            $redis -> connect(config('redis.host') , config('redis.port') , self::REDIS_CONNECT_TIME_OUT);
            $redis -> auth(config('redis.passwd'));
            $this -> redis = $redis;
        }
        catch (\Exception $e){
            throw new ParameterException($e -> getMessage() , $e -> getCode());
        }
    }

    public static function getInstance()
    {
        if( null == self::$instance ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function set($key , $value , $expire = 3600 , $encode = true) {
        $value && $encode && $value = json_encode($value);
        return $this -> redis->set($key, $value, $expire);
    }

    public function get($key , $decode = true) {
        $value = $this -> redis -> get($key);
        $value && $decode && $value = json_decode($value , true);
        return $value;
    }

    public function delete($key) {
        return $this -> redis -> del($key);
    }

    public function lPush($key , $value) {
        return $this -> redis -> lPush($key , $value);
    }
}