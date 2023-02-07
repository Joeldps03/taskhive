<?php

class bdd
{
    /**
     * @var array The default driver settings
     */
    private static $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "taskhive";

    //funció constructor
    public function __construct()
    {
        BdD::connect($this->servername, $this->username, $this->password, $this->database);
    }

    public static $connection;
    public static function connect($host, $user, $password, $database)
    {
        if (!isset(self::$connection)) {
            self::$connection = @new PDO(
                "mysql:host=$host;dbname=$database",
                $user,
                $password,
                    self::$settings
            );
        }
    }
    //Comprobem que l'usuari està registrat
    public static function login($nom, $password, $token)
    {
        
    }

    //Funció per a llsitar les tàsques
    public static function llistarTasques($rol, $nom)
    {

    }

    //Funció per a Editar les tàsques
    public static function editartasques($nom, $descripcio, $id_usuari, $prioritat, $estat, $comentari)
    {

    }

    //Funció per a crear les tàsques
    public static function crear($nom, $descripcio, $id_usuari, $prioritat, $estat, $comentari)
    {

    }

    //Funció per a crear les Usuaris
    public static function crearusuari($nom, $mail, $rol, $password)
    {
        //Generem Api key 
        $apikey = bin2hex(random_bytes(12));

    }

    //Funció per a editar les Usuaris
    public static function editarusuari($nom, $mail, $rol, $password, $apikey)
    {

    }

    //Funció per a llistar les Usuaris
    public static function llistarusuaris($rol)
    {

    }

}