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
            $conn = mysqli_connect();
            $sql = "INSERT INTO tokens (token) VALUES ('$token')";
            $resultat = $conn->query($sql);
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
            $bdd = new bdd();
            if ($accio == 'login') {
                if ($method == "POST") // validem que sigui per post
                {
                    
                } else {
                    header('HTTP/1.1 405 Method Not Allowed');
                }
            }
            if ($accio == 'tasques') {
                if ($method == "POST") // Diferenciarem el metode POST del GET
                {

                } else if ($method == "GET")
                {

                } else {
                    header('HTTP/1.1 405 Method Not Allowed');
                }
            }
            if ($accio == 'editartasques') {
                if ($method == "POST")
                {

                } else {
                    header('HTTP/1.1 405 Method Not Allowed');
                }
            }
            if ($accio == 'creartasca') {
                if ($method == "POST")
                {

                } else {
                    header('HTTP/1.1 405 Method Not Allowed');
                }
            }
            if ($accio == 'editarusuari') {
                if ($method == "POST")
                {

                } else {
                    header('HTTP/1.1 405 Method Not Allowed');
                }
            }
            if ($accio == 'usuari') {
                if ($method == "GET")
                {

                } else {
                    header('HTTP/1.1 405 Method Not Allowed');
                }
            }
            if ($accio == 'crearusuari') {
                if ($method == "POST")
                {

                } else {
                    header('HTTP/1.1 405 Method Not Allowed');
                }
            } else {
                // només validem /contrasenya/validar
                header('HTTP/1.1 404 Not Found');
            }

            //funció per a generar token
            function generateToken()
            {
                //la coockie durarà una hora
                setcookie("token", bin2hex(random_bytes(24)), time() + 3600, "/");
                return $_COOKIE["token"];
            }
        }
    }
}
$server = new Server;
$server->serve();

?>