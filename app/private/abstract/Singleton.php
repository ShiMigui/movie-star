<?php
trait TSingleton {
    private static self $instance;

    private function __construct() {}

    public static function getInstance(): static {
        if (!isset(self::$instance)) self::$instance = new static();
        return self::$instance;
    }
}