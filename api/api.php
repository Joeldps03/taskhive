<?php
include './bdd.php';
class Server
{
    /*
    Function: serve
    Funció On farem totes les crides al fitxer bdd.php
    Parameters:
        Cap
    Returns:
        Headers d'estat del procediment
*/
    public function serve()
    {
        $bdd = new bdd();
        //mirem si tenim token convidat
        $data=json_decode(file_get_contents('php://input'));
        $token= null;

        //mirem si li estem passant un token
        if($data!= null){
            $token=$data->token;
        }
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $paths = explode('/', $uri);
        array_shift($paths); // Hack; get rid of initials empty string
        array_shift($paths);
        //agafem l'accio que volem desenvolupar
        $accio = array_shift($paths);
        $resource = array_shift($paths);

        //mirem si tenim token
        if ($token==null){
           echo(json_encode($bdd->inserirtoken_tokens()));
        }
        else if($token!= null){
            //mirem si el token és nostre
           if($bdd->existeixtokentokens($token) || $bdd->existeixtokenusuarisbool($token)){
                if ($accio == 'login') {
                    //Mirem si existeix el usuari
                        $token1=$bdd->login($data->correu,$data->contrasenya);
                        $pasar=array("token"=>$token1);
                        if($token1)
                            echo json_encode($pasar);
                }
                //acció que la utilitzem per a editar tasques
                else if ($accio == 'llistarunatasca') {
                    $llistartasca=null;
                    $llistartasca=$bdd->llistarunatasca($data->id);
                    $pasar=array("tasca"=>$llistartasca);
                    echo json_encode($pasar);
                }
                //aquí llistem les tasques
                else if ($accio == 'tasques') {
                    $usuari=$bdd->existeixtokenusuaris($token);
                    $llistartasques=null;
                    //mirem rol per saber les tàsques que hem de llistar
                    if ($usuari["rol"] == "tecnic") {
                        $llistartasques=$bdd->llistarTasquesUser($usuari["id"]);
                    } else {
                        $llistartasques=$bdd->llistarTasques();
                        header('HTTP/1.1 202 Goel Gestor');
                    }
                    //retornem les tasques llistades a l'usuari
                    $pasar=array("usuari"=>$usuari,"tasques"=>$llistartasques);
                    echo json_encode($pasar);
                }
                else if ($accio == 'editartasques') {
                    //cridem a la funcio de la api per a editar les tasques
                    $bdd->editartasques($data->id,$data->nom, $data->descripcio, $data->id_usuari, $data->prioritat, $data->estat, $data->comentaris_tecnics);
                }
                else if ($accio == 'editartasquestecnic') {
                    //cridem a la funcio de la api per a editar les tasques
                    $bdd->editartasquestecnic($data->id,$data->estat, $data->comentaris_tecnics);
                }
                else if ($accio == 'creartasca') {
                    if ($method == "POST") {
                        $bdd->creartasques($data->nom, $data->descripcio, $data->id_usuari, $data->prioritat, $data->estat, $data->comentaris_tecnics);
                    } else {
                        header('HTTP/1.1 405 Mètode no disponible');
                    }
                }
                else if ($accio == 'eliminar') {
                    $bdd->eliminartasques($data->idtasca);
                }
                //funció per a llistar els usuaris
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
                }
                //si no revem cap acció li enviem aquest header 
                else {
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