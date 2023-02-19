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
            // if ($data->id != null){
            //     $id=$data->id;
            // }
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
        else if($token!= null){
           if($bdd->existeixtokentokens($token) || $bdd->existeixtokenusuarisbool($token)){
                if ($accio == 'login') {
                    //Mirem si existeix el usuari
                    // if ($bdd->login($data->correu,$data->contrasenya)) {

                        $token1=$bdd->login($data->correu,$data->contrasenya);
                        $pasar=array("token"=>$token1);
                        if($token1)
                            echo json_encode($pasar);
                    // } else
                    //     header('HTTP/1.1 404 usuari no trobat');
                }
                else if ($accio == 'llistarunatasca') {
                    //Controlem el tipus d'usuari
                    $llistartasca=null;
                    $llistartasca=$bdd->llistarunatasca($data->id);
                    $pasar=array("tasca"=>$llistartasca);
                    echo json_encode($pasar);
                }
                else if ($accio == 'tasques') {
                    //Controlem el tipus d'usuari
                    $usuari=$bdd->existeixtokenusuaris($token);
                    $llistartasques=null;
                    if ($usuari["rol"] == "tecnic") {
                        $llistartasques=$bdd->llistarTasquesUser($usuari["id"]);
                    } else {
                        $llistartasques=$bdd->llistarTasques();
                        header('HTTP/1.1 202 Goel Gestor');
                    }
                    $pasar=array("usuari"=>$usuari,"tasques"=>$llistartasques);
                    echo json_encode($pasar);
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
                        $bdd->creartasques($data->nom, $data->descripcio, $data->id_usuari, $data->prioritat, $data->estat, $data->comentaris_tecnics);
                    } else {
                        header('HTTP/1.1 405 Mètode no disponible');
                    }
                }
                else if ($accio == 'eliminar') {
                    if ($method == "POST") {
                        $bdd->eliminartasques($data->id);
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
                    $llistarusuaris=null;
                    $llistarusuaris=$bdd->llistarusuaris();
                    $pasardades=array("usuaris"=>$llistarusuaris);
                    echo json_encode($pasardades);
                }
                else if ($accio == 'crearusuari') {
                    if ($method == "POST") {
                        $bdd->crearusuari($data->nom,$data->correu,$data->rol,$data->contrasenya);
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