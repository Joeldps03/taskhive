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
    //FUnció per a establir conecció amb la base de daddes
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
    public static function login($email, $contrasenya)
    {
        $SQL = "SELECT * FROM usuaris WHERE email = :email AND contrasenya = :contrasenya";
        $consulta = (BdD::$connection)->prepare($SQL);
        $consulta->bindParam(':email',$email);
        $consulta->bindParam(':contrasenya',$contrasenya);
        $qFiles = $consulta->execute(); 
        // generem token a la taula usuaris
        $bdd=new bdd;
        $bdd -> inserirtoken_users($email);
        //Retornem un boleà 
        if ($consulta->rowCount() > 0)
            return true;
        else
            return false;
    }

    //funció per a retornar la id de un usuari a partir del nom
    public static function get_id($nom)
    {
        $SQL = "SELECT * FROM usuaris WHERE nom = :nom";
        $consulta = (BdD::$connection)->prepare($SQL);
        $consulta->bindParam(':nom',$nom);
        $qFiles = $consulta->execute(); 
        $result = $consulta->fetch();
        return $result["id"];
    }


    //Funció per a llsitar les tàsques del tèctic
    public static function llistarTasquesUser($id_usuari)
    {
        try 
        {
            $resposta=null;
            //select de les tàsques ordenades per prioritat
            $SQL = "SELECT * FROM tasques WHERE id_usuari = :id_usuari ORDER BY prioritat";
            $consulta = (BdD::$connection)->prepare($SQL);
            //passant el id del usuari aconseguim mostrar només les taques assignades a aquell usuari
            $consulta->bindParam("id_usuari", $id_usuari);
            $consulta->setFetchMode(PDO::FETCH_ASSOC);
            $qFiles = $consulta->execute(); 
            $result = $consulta->fetchAll();
            if ($consulta->rowCount() > 0){
                //retornem un array de les tàsques
                foreach($result as $tasca){
                    $resposta[]=$tasca;
                }
            }
            return $resposta;
        }
        catch(PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    //listar usuaris per a l'admin i el gestor
    public static function llistarTasques()
    {
        try 
        {
            $resposta=null;
            //Aqui veurem totes les entrades a la taula de tasques
            $SQL = "SELECT * FROM tasques ORDER BY prioritat";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->setFetchMode(PDO::FETCH_ASSOC);
            $qFiles = $consulta->execute(); 
            $result = $consulta->fetchAll();
            if ($consulta->rowCount() > 0){
                //retornem un array de les tàsques
                foreach($result as $tasca){
                    $resposta[]=$tasca;
                }
            }
            return $resposta;
        }
        catch(PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    //Funció per a Editar les tàsques per admin i gestor
    //Poden editar tot
    public static function editartasques($id, $nom, $descripcio, $id_usuari, $prioritat, $estat, $comentari)
    {
        try {
            //consulta d'inserció
            $SQL = "UPDATE tasques SET nom = :nom, descripcio =:descripcio, id_usuari=:id_usuari, prioritat=:prioritat, estat=:estat, comentaris_tecnics=:comentaris_tecnics WHERE id = :id";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->bindParam("nom", $nom);
            $consulta->bindParam("descripcio", $descripcio);
            $consulta->bindParam("id_usuari", $id_usuari);
            $consulta->bindParam("prioritat", $prioritat);
            $consulta->bindParam("estat", $estat);
            $consulta->bindParam("comentaris_tecnics", $comentari);
            $consulta->bindParam("id", $id);
            try {
                $result = $consulta->execute();
            } catch (PDOException $e) {
                echo "Errada en l'actualització: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Errada en la conexió: " . $e->getMessage();
        }
    }

    //Editar tasques pel tècnic
    //només estat i comentaris
    public static function editartasquestecnic($id, $estat, $comentari)
    {
        try {
            //consulta d'inserció
            $SQL = "UPDATE tasques SET estat=:estat, comentaris_tecnics=:comentaris_tecnics WHERE id = :id";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->bindParam("estat", $estat);
            $consulta->bindParam("comentaris_tecnics", $comentari);
            $consulta->bindParam("id", $id);
            try {
                $result = $consulta->execute();
            } catch (PDOException $e) {
                echo "Errada en l'actualització: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Errada en la conexió: " . $e->getMessage();
        }
    }

    //Funció per a crear les tàsques
    //Usuari tèctic no te accés
    public static function creartasques($nom, $descripcio, $id_usuari, $prioritat, $estat, $comentaris_tecnics)
    {
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
            } catch (PDOException $e) {
                echo "Errada en la inserció: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Errada en la conexió: " . $e->getMessage();
        }
    }

    //Eliminar tasques
    public static function eliminartasques($id){
        try {
            //consulta d'inserció
            $SQL = "DELETE FROM tasques WHERE id = :id";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->bindParam("id", $id);
            try {
                $result = $consulta->execute();
            } catch (PDOException $e) {
                echo "Errada en la inserció: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Errada en la conexió: " . $e->getMessage();
        }

    }

    //Funció per a crear les Usuaris
    //Funció disponible per a l'admin
    public static function crearusuari($nom, $mail, $rol, $password)
    {
        try 
        {
            $SQL = "INSERT INTO usuaris (nom, email, rol, contrasenya) VALUES (:nom, :email, :rol, :contrasenya)";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->bindParam("nom",$nom);
            $consulta->bindParam("email",$mail);
            $consulta->bindParam("rol",$rol);
            $consulta->bindParam("contrasenya",$password);
            try
            {
                $result = $consulta->execute();
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
    // funció disponible per a l'admin
    public static function editarusuari($id,$nom, $email, $rol, $contrasenya)
    {
        try {
            //consulta d'inserció
            $SQL = "UPDATE usuaris SET nom=:nom, email=:email, rol=:rol, contrasenya=:contrasenya WHERE id = :id";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->bindParam("nom", $nom);
            $consulta->bindParam("email", $email);
            $consulta->bindParam("rol", $rol);
            $consulta->bindParam("contrasenya", $contrasenya);
            $consulta->bindParam("id", $id);
            try {
                $result = $consulta->execute();
            } catch (PDOException $e) {
                echo "Errada en la inserció: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Errada en la conexió: " . $e->getMessage();
        } 
    }

    //Funció per a llistar les Usuaris
    //Disponible per a l'admin
    public static function llistarusuaris()
    {
        try 
        {
            $resposta=null;
            //select de les tàsques ordenades per prioritat
            $SQL = "SELECT * FROM usuaris ORDER BY nom";
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

    //Funció per a incerir token a la taula dels usuaris
    public static function inserirtoken_users($email)
    {
        $token=bin2hex(random_bytes(9));
        $token=$email.$token;
        try {
            //Fem un update ja que sempre actualutzarà el valor, tant si és null com si no
            $SQL = "UPDATE usuaris SET token=:token WHERE email = :email";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->bindParam("token", $token);
            $consulta->bindParam("email", $email);
            try {
                $result = $consulta->execute();
            } catch (PDOException $e) {
                echo "Errada en la inserció: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Errada en la conexió: " . $e->getMessage();
        } 
    }

    //Fem insert de token a la taula de tokens
    public static function inserirtoken_tokens()
    {
        try {
            $token = bin2hex(random_bytes(20));
            //consulta d'inserció a la taula tokens
            $SQL = "INSERT INTO tokens (token) VALUES (:token)";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->bindParam("token", $token);
            try {
                $result = $consulta->execute();
                return $token;
            } catch (PDOException $e) {
                echo "Errada en la inserció: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Errada en la conexió: " . $e->getMessage();
        }
    }

    //Funció per a eliminar tokens de la taula de tokens
    public static function deletetokendetokens($token){
        try {
            //Consulta per eliminar el registre de la taula de tokens
            $SQL = "DELETE FROM tokens WHERE token = :token";
            $consulta = (BdD::$connection)->prepare($SQL);
            $consulta->bindParam("token", $token);
            try {
                $result = $consulta->execute();
            } catch (PDOException $e) {
                echo "Errada en la inserció: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Errada en la conexió: " . $e->getMessage();
        }

    }

    //Mirar si el token és existent
    public static function existeixtokentokens($token)
    {
        //Select per mirar el token de les dades
        $SQL = "SELECT * FROM tokens WHERE token = :token";
        $consulta = (BdD::$connection)->prepare($SQL);
        $consulta->bindParam(':token',$token);
        $qFiles = $consulta->execute(); 
        var_dump( $consulta->rowCount());
        if ($consulta->rowCount() > 0)
            return true;
        else
            return false;
    }

    //Mirar si el token és existent i retorna tot el usuari
    public static function existeixtokenusuaris($token)
    {
        $result=null;
        //Consulta per mirar si el token existeix
        $SQL = "SELECT * FROM usuaris WHERE token = :token";
        $consulta = (BdD::$connection)->prepare($SQL);
        $consulta->bindParam(':token',$token);
        $qFiles = $consulta->execute(); 
        $result = $consulta->fetch();
        if ($consulta->rowCount() > 0){
            return $result;
        }
        else 
            return false;
    }
}