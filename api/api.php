<?php            
include './bdd.php';
class Server
{
    public function serve()
    {
        //mirem si tenim la cookie del token generada, en cas contrari generem el token
        if (!$_COOKIE["token"]) {
            //generem el valor del tocken
            $token = generateToken();
            //creem la connecció i inserim el token generat a la base de dades dels tokens
            $bdd = new bdd();
            $bdd->inserirtokentokens($token);
            //una vegada generada la cookie hauriem de recarregar la pàgina
        }
        //en cas afirmatiu carreguem tota la pàgina
        else {
            $uri = $_SERVER['REQUEST_URI'];
            $method = $_SERVER['REQUEST_METHOD'];
            $paths = explode('/', $uri);
            array_shift($paths); // Hack; get rid of initials empty string
            array_shift($paths);
            $clau = array_shift($paths);
            $resource = array_shift($paths);
            $accio = array_shift($path);
            //instanciem un objecte bdd per poder accedir-hi
            //al instanciar el mètode s'estableix connecció a la base de dades
            $bdd = new bdd();
            if ($accio == 'login') {
                if ($method == "POST") // validem que sigui per post
                {
                    $bdd->login($_POST["nom"]);
                } else {
                    header('HTTP/1.1 405 Mètode no disponible');
                }
            }
            if ($accio == 'tasques') {
                if ($method == "POST") 
                {
                    //Controlem el tipus d'usuari
                    if($_POST["rol"]=="tecnic"){
                        $bdd->llistarTasquesUser($_POST["id_usuari"]);
                    }
                    else{
                        //si no és tècnic mostrem totes les tasques
                        $bdd->llistarTasques();
                    }
                } else {
                    header('HTTP/1.1 405 Mètode no disponible');
                }
            }
            if ($accio == 'editartasques') {
                if ($method == "POST")
                {
                    //Aquí hem de controlar el rol del usuari que fa la petició
                    if($_POST["rol"]=="tecnic"){
                        $bdd->editartasquestecnic($_POST["id"],$_POST["estat"],$_POST["comentari"]);
                    }
                    else{
                        //Tant el gestor com l'admin poden editar la tasca sencera
                        $bdd->editartasques($_POST["id"],$_POST["nom"],$_POST["descripcio"],$_POST["id_usuari"],$_POST["prioritat"],$_POST["estat"],$_POST["comentari"]);
                    }
                } else {
                    header('HTTP/1.1 405 Mètode no disponible');
                }
            }
            if ($accio == 'creartasca') {
                if ($method == "POST")
                {
                    $bdd->creartasques($_POST["nom"],$_POST["descripcio"],$_POST["id_usuari"],$_POST["prioritat"],$_POST["estat"],$_POST["comentari"]);
                } else {
                    header('HTTP/1.1 405 Mètode no disponible');
                }
            }
            if ($accio == 'eliminar') {
                if ($method == "POST")
                {
                    $bdd->eliminartasques($_POST["id"]);
                } else {
                    header('HTTP/1.1 405 Mètode no disponible');
                }
            }
            if ($accio == 'editarusuari') {
                if ($method == "POST")
                {
                    $bdd->editarusuari($_POST["id"],$_POST["nom"],$_POST["email"],$_POST["rol"],$_POST["contrasenya"]);
                } else {
                    header('HTTP/1.1 405 Mètode no disponible');
                }
            }
            if ($accio == 'usuari') {
                if ($method == "GET")
                {
                    $bdd->llistarusuaris();
                } else {
                    header('HTTP/1.1 405 Mètode no disponible');
                }
            }
            if ($accio == 'crearusuari') {
                if ($method == "POST")
                {
                    $bdd->crearusuari($_POST["nom"],$_POST["email"],$_POST["rol"],$_POST["contrasenya"]);
                } else {
                    header('HTTP/1.1 405 Mètode no disponible');
                }
            } else {
                // només validem /contrasenya/validar
                header('HTTP/1.1 404');
            }

            //funció per a generar token
            function generateToken()
            {
                //la coockie durarà una hora
                setcookie("token", bin2hex(random_bytes(24)), time() + (3600), "/");
                return $_COOKIE["token"];
            }
            function generateToken2()
            {
                //borrem token vell
                setcookie("token", bin2hex(random_bytes(24)), time()+ 0, "/");
                //la coockie durarà una hora
                setcookie("token2", bin2hex(random_bytes(24)), time() + 3600, "/");
                return $_COOKIE["token2"];
            }
        }
    }
}
$server = new Server;
$server->serve();

?>