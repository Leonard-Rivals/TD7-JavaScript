<?php

class Conf {

    private static $database = array(
        'hostname' => 'webinfo.iutmontp.univ-montp2.fr',
        'database' => 'cadarsir',
        'login'    => 'cadarsir',
        'password' => 'nT1HuhR2GlocUpEI'
    );

    static public function getLogin() {
        return self::$database['login'];
    }

    static public function getHostname() {
        return self::$database['hostname'];
    }

    static public function getDatabase() {
        return self::$database['database'];
    }

    static public function getPassword() {
        return self::$database['password'];
    }

}

?>
