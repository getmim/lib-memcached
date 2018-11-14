<?php
/**
 * Memcached
 * @package lib-memcached
 * @version 0.0.1
 */

namespace LibMemcached\Library;

class Memcached
{
    private static $conn = [];

    static function getConn(string $name): ?object{
        if(isset(self::$conn[$name]))
            return self::$conn[$name];

        $opts = \Mim::$app->config->libMemcached;
        if(!isset($opts->$name)){
            trigger_error('Memcached connection named `' . $name . '` not found');
            return null;
        }

        $opt = $opts->$name;

        $instance = $opt->instance ?? null;

        if($instance)
            $conn = new \Memcached($instance);
        else
            $conn = new \Memcached;

        if($conn->getResultCode() !== $conn::RES_SUCCESS)
            return null;

        $host   = $opt->host;
        $port   = $opt->port;
        $weight = $opt->weight ?? null;
        if($weight)
            $conn->addServer($host, $port, $weight);
        else
            $conn->addServer($host, $port);

        if(isset($conn->auth)){
            $name = $conn->auth->name;
            $pass = $conn->auth->pass;
            $conn->setSaslAuthData($name, $pass);
        }
        
        self::$conn[$name] = $conn;

        return self::$conn[$name];
    }

    static function __callStatic(string $name, array $args=[]){
        $conn = array_shift($args);
        if(!$conn)
            return trigger_error('No connection name provided');

        $rconn = self::getConn($conn);
        if(!$rconn)
            return;

        return call_user_func_array([$rconn, $name], $args);
    }
}