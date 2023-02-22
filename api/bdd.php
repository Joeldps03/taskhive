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

    /*
    Function: constructor
    Function per crear l'objecte base de dades
    Parameters:
        Cap
    Returns:
        No retorna res, és un procediment.

*/
    public function __construct()
    {
        BdD::connect($this->servername, $this->username, $this->password, $this->database);
    }

    public static $connection;

/*
    Function: connect
    Function per a establir conecció amb la base de daddes
    Parameters:
        $servername ,Nom del Servidor on està la base de dades
        $username , Usuari per Connectarse a la base de dades
        $password , Contrassenya de l'usuari
        $database , Especifiquem base de dades
    Returns:
        No Retorna res, és un procediment.
*/
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


/*
    Function: login
    Comprobem que l'usuari està registrat
    Parameters:
        $email ,Correu del usuari 
        $contrassenya , Contrassenya de l'usuari
    Returns:
        Token en cas de un login exitos, false en cas contrari
*/
    public static function login($email, $contrasenya)
    {
        $SQL = "SELECT * FROM usuaris WHERE email = :email AND contrasenya = :contrasenya";
        $consulta = (BdD::$connection)->prepare($SQL);
        $consulta->bindParam(':email',$email);
        $consulta->bindParam(':contrasenya',$contrasenya);
        $qFiles = $consulta->execute(); 
        // generem token a la taula usuaris
        $bdd=new bdd;
        $token=$bdd -> inserirtoken_users($email);
        //Retornem un boleà 
        if ($consulta->rowCount() > 0)
            return $token;
        else
            return false;
    }

    /*
    Function: get_id
    Function per a Retornar la id de un usuari a partir del nom
    Parameters:
        $nom ,nom del usuari 
    Returns:
        La id de l'usuari
*/
    public static function get_id($nom)
    {
        $SQL = "SELECT * FROM usuaris WHERE nom = :nom";
        $consulta = (BdD::$connection)->prepare($SQL);
        $consulta->bindParam(':nom',$nom);
        $qFiles = $consulta->execute(); 
        $result = $consulta->fetch();
        return $result["id"];
    }


    /*
    Function: llistarTasquesUser
    Function per a llsitar les tàsques del tèctic
    Parameters:
        $id_usuari ,nom del usuari 
    Returns:
        Una llista de tàsques
*/
    public static function llistarTasquesUser($id_usuari)
    {
        try 
        {
            $resposta=null;
            //select de les tàsques ordenades per prioritat
            $SQL = "SELECT * FROM tasques WHERE id_usuari = :id_usuari ORDER BY prioritat DESC";
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

/*
    Function: llistarunatasca
    Function per a llsitar una tasca, es fa servir a l'hora de interactuar amb una tasca
    Parameters:
        $id ,id de la tasca
    Returns:
        Una llista de una tasca
*/

    public static function llistarunatasca($id)
    {
        try 
        {
            $resposta=null;
            //select de les tàsques ordenades per prioritat
            $SQL = "SELECT * FROM tasques WHERE id = :id";
            $consulta = (BdD::$connection)->prepare($SQL);
            //passant el id del usuari aconseguim mostrar només les taques assignades a aquell usuari
            $consulta->bindParam("id", $id);
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
    


    /*
    Function: llistarTasques
    listar tasques per a l'admin i el gestor, llista tots els registres de la taula
    Parameters:
        Cap
    Returns:
        Una llista de tàsques
*/
    public static function llistarTasques()
    {
        try 
        {
            $resposta=null;
            //Aqui veurem totes les entrades a la taula de tasques
            $SQL = "SELECT * FROM tasques ORDER BY prioritat DESC";
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

    /*
    Function: editartasques
    Function per a Editar les tàsques per admin i gestor, Poden editar tot
    Parameters:
        $id, id de la tasca,
        $nom, Nom de la tasca,
        $descripcio, Descripció de la tasca,
        $id_usuari, id del usuari,
        $prioritat, Urgència de la tasca,
        $estat, En quin estat es trova,
        $comentari, Comentari del tècnic.
    Returns:
        No retorna res, és un procediment.
*/
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

        /*
    Function: editartasquestecnic
    Editar tasques pel tècnic, només estat i comentaris
    Parameters:
        $id, id de la tasca,
        $estat, En quin estat es trova,
        $comentari, Comentari del tècnic.
    Returns:
        No retorna res, és un procediment.
*/

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

/*
    Function: creartasques
    Function per a crear les tàsques, Usuari tèctic no te accés
    Parameters:
        $nom, Nom de la tasca,
        $descripcio, Descripció de la tasca,
        $id_usuari, id del usuari,
        $prioritat, Urgència de la tasca,
        $estat, En quin estat es trova,
        $comentari, Comentari del tècnic.
    Returns:
        No retorna res, és un procediment.
*/
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


    /*
    Function: eliminartasques
    Function per eliminar tasques
    Parameters:
        $id, id de la tasca,
    Returns:
        No retorna res, és un procediment.
*/

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


/*
    Function: crearusuari
    Function per a crear les Usuaris, Function disponible per a l'admin
    Parameters:
        $nom, Nom de l'usuari ,
        $mail, mail de l'usuari,
        $rol, rol del usuari,
        $password, Contrassenya de l'usuari
    Returns:
        No retorna res, és un procediment.
*/
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

/*
    Function: editarusuari
    Function per a llistar les Usuaris, disponible per a l'admin
    Parameters:
        Cap
    Returns:
        Una llista d'usuaris
*/
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
                //retornem un array dels usuaris
                foreach($result as $usuari){
                    $resposta[]=$usuari;
                }
            }
            return $resposta;
        }
        catch(PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }


/*
    Function: inserirtoken_users
    Function per a incerir token a la taula dels usuaris
    Parameters:
        $email, Correu del usuari
    Returns:
        Token de l'usuari
*/
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
                return $token;
            } catch (PDOException $e) {
                echo "Errada en la inserció: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Errada en la conexió: " . $e->getMessage();
        } 
    }

/*
    Function: inserirtoken_tokens
    Fem insert de token a la taula de tokens
    Parameters:
        Cap
    Returns:
        Token de l'usuari
*/

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

/*
    Function: deletetokendetokens
    Function per a eliminar tokens de la taula de tokens
    Parameters:
        $token, Token per eliminar
    Returns:
        No retorna res, és un procediment.
*/
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

/*
    Function: existeixtokentokens
    Mirar si el token és existent a la taula de token convidats
    Parameters:
        $token, Token per consultar
    Returns:
        true si existeix, false si no.,
*/

    public static function existeixtokentokens($token)
    {
        //Select per mirar el token de les dades
        $SQL = "SELECT * FROM tokens WHERE token = :token";
        $consulta = (BdD::$connection)->prepare($SQL);
        $consulta->bindParam(':token',$token);
        $qFiles = $consulta->execute(); 
        ( $consulta->rowCount());
        if ($consulta->rowCount() > 0)
            return true;
        else
            return false;
    }

    /*
    Function: existeixtokenusuaris
    Mirar si el token és existent i retorna tot el usuari
    Parameters:
        $token, Token per consultar 
    Returns:
        Usuari si existeix, false si no.,
*/
    public static function existeixtokenusuaris($token)
    {
        $result=null;
        //Consulta per mirar si el token existeix
        $SQL = "SELECT * FROM usuaris WHERE token = :token";
        $consulta = (BdD::$connection)->prepare($SQL);
        $consulta->bindParam(':token',$token);
        $qFiles = $consulta->execute(); 
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
        $result = $consulta->fetch();
        if ($consulta->rowCount() > 0){
            return $result;
        }
        else 
            return false;
    }

/*
    Function: existeixtokenusuarisbool
    Mirar si el token és existent i retorna tot el usuari
    Parameters:
        $token, Token per consultar 
    Returns:
        true si existeix, false si no.,
*/
    public static function existeixtokenusuarisbool($token)
    {
        $result=null;
        //Consulta per mirar si el token existeix
        $SQL = "SELECT * FROM usuaris WHERE token = :token";
        $consulta = (BdD::$connection)->prepare($SQL);
        $consulta->bindParam(':token',$token);
        $qFiles = $consulta->execute(); 
        $result = $consulta->fetch();
        if ($consulta->rowCount() > 0){
            return true;
        }
        else 
            return false;
    }
}
$bdd = new bdd();
$bdd->eliminartasques(4);