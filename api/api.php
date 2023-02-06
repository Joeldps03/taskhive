<?php
/*
    Versió Validar Contrasenya
    Per a poder usar la API, cal disposar d'una API-Key que li passarem per la URL
    codi = "AaBbCc"

    ruta de la API -> http://localhost/API/{Api-Key}/contrasenya/validar
*/

class Server {
    
    //funció que comprova si tenim la KEY
    private function ValidarUs($clau)
    {
        return ($clau=="AaBbCc");
    }

    public function serve() {
                     
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $paths = explode('/', $uri);
        array_shift($paths); // Hack; get rid of initials empty string
        array_shift($paths);
        $clau = array_shift($paths);
        $resource = array_shift($paths);
        $accio = array_shift($paths);
        
        if ($this->ValidarUs($clau))
        {
            if ($resource == 'contrasenya' and $accio == 'validar') 
            {
                if ($method == "PUT") // validem que sigui per GET
                {
                   $dades = json_decode(file_get_contents('php://input'));
                   // Ara validem
                   $punts = 0;
                   $comptM = 0;
                   $comptm = 0;
                   $compte = 0;
                   $comptn = 0;

                   // mida >=8
                   $mida = strlen($dades);                   

                    for ($i=0; $i<strlen($dades); $i++)
                        {
                            $car = substr($dades,$i,1);
                            if ($car >= "A" && $car <= "Z")
                                $comptM++;
                            if ($car >= "a" && $car <= "z")
                                $comptm++;
                            if ($car >= "0" && $car <= "9")
                                $comptn++;
                            if ($car == "*" || $car == "_")
                                $compte++;
                        }

                    if ($mida >= 8)
                        $punts++;
                    if ($mida >= 9)
                        $punts++;
                    if ($comptM >= 1)
                        $punts++;
                    if ($comptM >= 2)
                        $punts++;
                    if ($comptm >= 1)
                        $punts++;
                    if ($comptm >= 2)
                        $punts++;
                    if ($compte >= 2)
                        $punts++;
                    if ($compte >= 3)
                        $punts++;
                    if ($comptn >= 4)
                        $punts++;
                    if ($comptn >= 5)
                        $punts++;

                    // retornem valor
                   echo $punts;
                }
                else
                {
                    header('HTTP/1.1 405 Method Not Allowed');
                }
            } else {
                // només validem /contrasenya/validar
                header('HTTP/1.1 404 Not Found');
            }             
        }
        else
        {
          // No trobem una Key  vàlida
           header('HTTP/1.1 401 Unauthorized');
        }
    }
  }

$server = new Server;
$server->serve();

?>