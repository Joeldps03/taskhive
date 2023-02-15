<?php
include './bdd.php';
class Server
{
    public function serve()
    {
        // funció per a generar token
        // mirem si tenim la cookie del token generada, en cas contrari generem el token
        // if (!isset($_COOKIE["token"])) {
        //     //generem el valor del tocken
        //     $token = $this->generateToken();
        //     //creem la connecció i inserim el token generat a la base de dades dels tokens
        //     $bdd = new bdd();
        //     $bdd->inserirtokentokens($token);
        //     //una vegada generada la cookie hauriem de recarregar la pàgina
        // }
        //en cas afirmatiu carreguem tota la pàgina
        // else {
            $uri = $_SERVER['REQUEST_URI'];
            $method = $_SERVER['REQUEST_METHOD'];
            $paths = explode('/', $uri);
            array_shift($paths); // Hack; get rid of initials empty string
            array_shift($paths);
            $clau = array_shift($paths);
            $resource = array_shift($paths);
            $accio = array_shift($paths);
            var_dump($accio);
            //instanciem un objecte bdd per poder accedir-hi
            //al instanciar el mètode s'estableix connecció a la base de dades
            $bdd = new bdd();
            if ($accio == 'login') {
                //Mirem si existeix el usuari
                if ($bdd->login($_POST["correu"])) {
                    //mirem si l'usuari te un token assignat
                    //en cas de no tindre cap token assignat borrem el de la taula tokens generem un i l'inserim a la taula d'usuaris
                    if (!($bdd->existeixtokenusuaris($_COOKIE["token"]))) {
                        $bdd->deletetokendetokens($_COOKIE["token"]);
                        //Generem un token nou
                        $this->generateToken2();
                        //inserim a la base de dades de l'usuari
                        try {
                            $bdd->inserirtokenusers($bdd->get_id($_POST["nom"]), $_COOKIE["token"]);
                        } catch (PDOException $e) {
                            echo "Errada en la incerció: " . $e->getMessage();
                        }
                    }
                } else
                    header('HTTP/1.1 404 usuari no trobat');
            }
            else if ($accio == 'tasques') {
                // if ($method == "POST") {
                    //Controlem el tipus d'usuari
                    if ($_POST["rol"] == "tecnic") {
                        $bdd->llistarTasquesUser($_POST["id_usuari"]);
                    } else {
                        //si no és tècnic mostrem totes les tasques
                        $llistar = $bdd->llistarTasques();

                        echo json_encode($llistar);
                    }
                // } else {
                //     header('HTTP/1.1 405 Mètode no disponible');
                // }
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
    function generateToken()
    {
        $cookieToken = bin2hex(random_bytes(24));
        setcookie("token", $cookieToken, time() + (3600), "/");
        return $cookieToken;
    }
    function generateToken2()
    {
        $cookieToken = bin2hex(random_bytes(24));
        setcookie("token", $cookieToken, time() + (0), "/");
        setcookie("token2", $cookieToken, time() + (3600), "/");
        return $cookieToken;
 }
// }
$server = new Server;
$server->serve();

?>