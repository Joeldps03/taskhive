<?php
include './bdd.php';
class Server
{
    public function serve()
    {
        $bdd = new bdd();
        //mirem si tenim token convidat
        $data=json_decode(file_get_contents('php://input'));
        $token= null;

        //mirem si lki estem passant un token
        if($data!= null){
            $token=$data->token;
            // $id=$data->id;
        }
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $paths = explode('/', $uri);
        array_shift($paths); // Hack; get rid of initials empty string
        array_shift($paths);
        $accio = array_shift($paths);
        $resource = array_shift($paths);

        //mirem si tenim token
        if ($token==null){
            echo(json_encode($bdd->inserirtoken_tokens()));
        }
        //si tenim token mirem usuari connectat
        // else if ($id==null){
        //     echo(json_encode($bdd->existeixtokenusuaris($token)));
        // }
        else if($token!= null){
            // echo $bdd->existeixtokentokens($token);
            if($bdd->existeixtokentokens($token) || $bdd->existeixtokenusuaris($token)){
                if ($accio == 'login') {
                    //Mirem si existeix el usuari
                    if ($bdd->login($data->correu,$data->contrasenya)) {
                        header('HTTP/1.1 200 LOGIN');
                    } else
                        header('HTTP/1.1 404 usuari no trobat');
                }
                else if ($accio == 'tasques') {
                    //Controlem el tipus d'usuari
                    if ($data->rol == "tecnic") {
                        header('HTTP/1.1 202 Gorl Tecnic');
                        // $bdd->llistarTasquesUser($_POST["id_usuari"]);
                    } else {
                        header('HTTP/1.1 202 Goel Gestor');
                        //si no és tècnic mostrem totes les tasques
                        // $bdd->llistarTasques();
                    }
                }
                else if ($accio == 'editartasques') {
                    if ($method == "POST") {
                        //Aquí hem de controlar el rol del usuari que fa la petició
                        if ($data->correu == "tecnic") {
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
                    header('HTTP/1.1 404 metode no trobat');
                }
            }
            else{
                header('HTTP/1.1 401 unautorizet');
                echo json_encode(false);
            }
        }
    }
}
$server = new Server;
$server->serve();

?>