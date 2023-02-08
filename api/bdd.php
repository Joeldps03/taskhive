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
    public static function login($nom, /*$password, $token*/)
    {
        $SQL = "SELECT * FROM usuaris WHERE nom = :nom";
        $consulta = (BdD::$connection)->prepare($SQL);
        $consulta->bindParam(':nom',$nom);
        $qFiles = $consulta->execute(); 
        var_dump( $consulta->rowCount());
        if ($consulta->rowCount() > 0)
            return true;
        else
            return false;
    }

    //Funció per a llsitar les tàsques
    public static function llistarTasquesUser($id_usuari)
    {
        try 
        {
            $resposta=null;
            //select de les tàsques ordenades per prioritat
            $SQL = "SELECT * FROM tasques WHERE id_usuari = :id_usuari ORDER BY prioritat";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->bindParam("id_usuari", $id_usuari);
            $consulta->setFetchMode(PDO::FETCH_ASSOC);
            $qFiles = $consulta->execute(); 
            $result = $consulta->fetchAll();
            if ($consulta->rowCount() > 0){
                foreach($result as $tasca){
                    $resposta[]=$tasca;
                }
            }
            else{
                echo "no Funciona";
                exit;
            }
            return $resposta;
        }
        catch(PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    public static function llistarTasques()
    {
        try 
        {
            $resposta=null;
            //select de les tàsques ordenades per prioritat
            $SQL = "SELECT * FROM tasques ORDER BY prioritat";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->setFetchMode(PDO::FETCH_ASSOC);
            $qFiles = $consulta->execute(); 
            $result = $consulta->fetchAll();
            if ($consulta->rowCount() > 0){
                foreach($result as $tasca){
                    $resposta[]=$tasca;
                }
            }
            else{
                echo "no Funciona";
                exit;
            }
            return $resposta;
        }
        catch(PDOException $e) {
            return "Error: " . $e->getMessage();
        }

    }

    //Funció per a Editar les tàsques
    public static function editartasques($nom, $descripcio, $id_usuari, $prioritat, $estat, $comentari)
    {

    }

    //Funció per a crear les tàsques
    public static function creartasques($nom, $descripcio, $id_usuari, $prioritat, $estat, $comentaris_tecnics)
    {
        //a id usuari es farà un select per a comprobar el rol i verificar si pot generar tasques
        //de moment:
        $rol = "admin";
        if ($rol == "tecnic") {
            echo ("No tens permisos per afegir tasques");
        } else {
            try {
                //consulta d'inserció
                $SQL = "INSERT INTO tasques (nom, descripcio, id_usuari, prioritat, estat, comentaris_tecnics) VALUES (:nom, :descripcio, :id_usuari, :prioritat, :estat, :comentaris_tecnics)";
                $consulta = (BdD::$connection)->prepare($SQL);
                $consulta->bindParam("nom", $nom);
                $consulta->bindParam("descripcio", $descripcio);
                $consulta->bindParam("id_usuari", $id_usuari);
                $consulta->bindParam("prioritat", $prioritat);
                $consulta->bindParam("estat", $estat);
                $consulta->bindParam("comentaris_tecnics", $comentaris_tecnics);
                // executem
                try {
                    $result = $consulta->execute();
                    if ($result)
                        echo "Inserció realitzada";
                    else
                        echo "Inserció no realitzada";
                } catch (PDOException $e) {
                    echo "Errada en la inserció: " . $e->getMessage();
                }
            } catch (PDOException $e) {
                echo "Errada en la conexió: " . $e->getMessage();
            }
        }
    }

    //Funció per a crear les Usuaris
    public static function crearusuari($nom, $mail, $rol, $password)
    {
        //Generem Api key 
        // $apikey = bin2hex(random_bytes(12));
        try 
        {
            //consulta d'inserció
            $SQL = "INSERT INTO usuaris (nom, email, rol, contrasenya) VALUES (:nom, :email, :rol, :contrasenya)";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->bindParam("nom",$nom);
            $consulta->bindParam("email",$mail);
            $consulta->bindParam("rol",$rol);
            $consulta->bindParam("contrasenya",$password);
            // executem
            try
            {
                $result = $consulta->execute();
            
                if ($result)	
                    echo "Inserció realitzada";
                else
                    echo "Inserció no realitzada";
            }
            catch(PDOException $e)
            {
                echo "Errada en la inserció: " . $e->getMessage();
            }
        
        }
        catch(PDOException $e) {
            echo "Errada en la conexió: " . $e->getMessage();
        }
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