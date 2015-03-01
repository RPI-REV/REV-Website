<?php

namespace REVBuild;

class SQL {
    const propel_bin = '"vendor/bin/propel" ';
    const config_dir = ' --config-dir="app/propel" ';
    const schema_dir = ' --schema-dir="app/propel" ';
    const sql_dir = ' --sql-dir="app/propel/generated-sql" ';

    public static function build() {
        echo '*** Building SQL'. PHP_EOL;
        @unlink('app/propel/generated-sql\sqldb.map');
        exec(self::propel_bin . 'sql:build' .
            self::config_dir .
            self::schema_dir .
            '--output-dir="app/propel/generated-sql');
    }

    public static function deploy() {
        echo '*** Deploying SQL' . PHP_EOL;
        exec(self::propel_bin . 'sql:insert' .
            self::config_dir .
            self::sql_dir);
    }

    public static function diff() {
        echo '*** Creating migration'. PHP_EOL;
        exec(self::propel_bin . 'diff' .
            self::sql_dir .
            self::config_dir .
            '--output-dir="app/propel/generated-migration"');
    }

    public static function migrate() {
        self::diff();
        echo '*** Running migration'. PHP_EOL;
        exec(self::propel_bin . 'migrate' .
            self::config_dir .
            '--output-dir="app/propel/generated-migration"');
    }
}