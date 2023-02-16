<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: *');
include './bdd.php';
class Server
{
    public function serve()
    {
        echo "U";
        header('HTTP/1.1 200 OK');
        exit();

        $bdd = new bdd();
        echo(json_encode($bdd->inserirtoken_tokens()));
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $paths = explode('/', $uri);
        array_shift($paths); // Hack; get rid of initials empty string
        array_shift($paths);
        $clau = array_shift($paths);
        $resource = array_shift($paths);
        $accio = array_shift($paths);
        //instanciem un objecte bdd per poder accedir-hi
        //al instanciar el mètode s'estableix connecció a la base de dades

        if ($accio == 'login') {
            //Mirem si existeix el usuari
            if ($bdd->login($_POST["correu"])) {
                //header de tasques
            } else
                header('HTTP/1.1 404 usuari no trobat');
        }
        else if ($accio == 'tasques') {
            if ($method == "POST") {
                //Controlem el tipus d'usuari
                if ($_POST["rol"] == "tecnic") {
                    $bdd->llistarTasquesUser($_POST["id_usuari"]);
                } else {
                    //si no és tècnic mostrem totes les tasques
                    $bdd->llistarTasques();
                }
            } else {
                header('HTTP/1.1 405 Mètode no disponible');
            }
        }
        else if ($accio == 'editartasques') {
            if ($method == "POST") {
                //Aquí hem de controlar el rol del usuari que fa la petició
                if ($_POST["rol"] == "tecnic") {
                    $bdd->editartasquestecnic($_POST["id"], $_POST["estat"], $_POST["comentari"]);
                } else {
                    //Tant el gestor com l'admin poden editar la tasca sencera
                    $bdd->editartasques($_POST["id"], $_POST["nom"], $_POST["descripcio"], $_POST["id_usuari"], $_POST["prioritat"], $_POST["estat"], $_POST["comentari"]);
                }
            } else {
                header('HTTP/1.1 405 Mètode no disponible');
            }
        }
        else if ($accio == 'creartasca') {
            if ($method == "POST") {
                $bdd->creartasques($_POST["nom"], $_POST["descripcio"], $_POST["id_usuari"], $_POST["prioritat"], $_POST["estat"], $_POST["comentari"]);
            } else {
                header('HTTP/1.1 405 Mètode no disponible');
            }
        }
        else if ($accio == 'eliminar') {
            if ($method == "POST") {
                $bdd->eliminartasques($_POST["id"]);
            } else {
                header('HTTP/1.1 405 Mètode no disponible');
            }
        }
        else if ($accio == 'editarusuari') {
            if ($method == "POST") {
                $bdd->editarusuari($_POST["id"], $_POST["nom"], $_POST["email"], $_POST["rol"], $_POST["contrasenya"]);
            } else {
                header('HTTP/1.1 405 Mètode no disponible');
            }
        }
        else if ($accio == 'usuari') {
            if ($method == "GET") {
                $bdd->llistarusuaris();
            } else {
                header('HTTP/1.1 405 Mètode no disponible');
            }
        }
        else if ($accio == 'crearusuari') {
            if ($method == "POST") {
                $bdd->crearusuari($_POST["nom"], $_POST["email"], $_POST["rol"], $_POST["contrasenya"]);
            } else {
                header('HTTP/1.1 405 Mètode no disponible');
            }
        } else {
            // només validem /contrasenya/validar
            header('HTTP/1.1 404');
        }

    }
}
$server = new Server;
$server->serve();

?>