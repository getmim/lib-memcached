<?php
/**
 * Memcached server tester
 * @package lib-memcached
 * @version 0.0.1
 */

namespace LibMemcached\Server;

class PHP
{
    static function memcached(){
        $result = [
            'success' => false,
            'info' => 'Not installed'
        ];

        $exists = class_exists('Memcached');
        
        if(!$exists)
            return $result;
        
        return [
            'success' => true,
            'info' => '-'
        ];
    }
}