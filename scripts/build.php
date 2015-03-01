<?php

namespace REVBuild;

class build {
    const propel_bin = '"vendor/bin/propel" ';
    const config_dir = ' --config-dir="app/propel" ';
    const schema_dir = ' --schema-dir="app/propel" ';
    
    public static function model() {
        echo '*** Building models' . PHP_EOL;
        exec(self::propel_bin . 'model:build' .
            self::config_dir .
            self::schema_dir .
            '--output-dir="app/propel/generated-classes');
    }
    
    public static function config() {
        echo '*** Building config' . PHP_EOL;
        exec(self::propel_bin . 'config:convert' .
            self::config_dir .
            '--output-dir="app/propel/generated-conf');
    }
    
    public static function clearCache() {
        echo '*** Deleting cache' . PHP_EOL;
        
        function rrmdir($dir) {
            if (is_dir($dir)) {
                $objects = scandir($dir);
                
                foreach ($objects as $object) {
                    if ($object != '.' && $object != '..') {
                        if (filetype($dir . '/' . $object) == 'dir') {
                            rrmdir($dir . '/' . $object);
                        } else {
                            unlink($dir . '/' . $object);
                        }
                    }
                }
                
                reset($objects);
                rmdir($dir);
            }
        }
        
        rrmdir(__DIR__ . '/app/assets/cache');
    }
    
    public static function makeCache() {
        echo '*** creating cache' . PHP_EOL;
        @mkdir('app/assets/cache');
        
        $dirs = ['js', 'css', 'coffee', 'sass', 'image'];
        
        foreach ($dirs as $dir) {
            echo '*** Ensuring ' . $dir . ' directory' . PHP_EOL;
            @mkdir('app/assets/' . $dir);
            echo '*** Ensuring ' . $dir . ' cache' . PHP_EOL;
            @mkdir('app/assets/cache' . $dir);
        }
    }
    
    public static function dumpAutoload() {
        echo '*** Dumping autoload' . PHP_EOL;
        exec('composer dump-autoload');
    }
    
    public static function build() {
        self::clearCache();
        self::makeCache();
        SQL::build();
        self::model();
        self::config();
        self::dumpAutoload();
    }
    
    public static function deploy() {
        SQL::build();
        self::model();
        self::config();
        self::dumpAutoload();
        SQL::deploy();
    }
}