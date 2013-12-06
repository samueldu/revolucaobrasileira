<?
    // Pré configs
    ini_set("memory_limit", "4000M");
    ini_set('max_execution_time','100000000000000000000000000000000');
    set_time_limit('100000000000000000000000000000000');
    flush();
    
    function pinga($url)
    {   
        $resposta = "fail";
        
        $pingando = shell_exec("ping -c 1 $url") or die();
        print_r($pingando);
        if(!ereg("bytes from",$pingando))
        {
            $resposta = "fail";
            
            $teste = fsockopen($url, 80, $errno, $errstr, 10); 
            
            if($teste)
            $resposta = "ok";
            
        }
        else
        {
            $resposta = "ok";
        }
        
        return $resposta;
    }
    
    function atualizaGeoTracking()
    {
        $url = "http://geolite.maxmind.com/download/geoip/database/"; 
        $arquivo = "GeoLiteCity.dat.gz";
        $arquivoDestino = "GeoLiteCity.dat";
        
       // $teste = pinga($url);

       // if($teste == "ok")
        //{
            if(!copy($url.$arquivo,$arquivo))
            {
                $errors= error_get_last();
                print_r($errors);
                print "COPY ERROR: ".$errors['type'];
                print "<br />\n".$errors['message'];
            }
            else
            {
                
                $p = exec('gunzip -f -v '.$arquivo, $arquivoDestino);         
            }      
       // }
       // else
       // {
        //    print "Servidor fora do ar";
        //}
    }
    
    atualizaGeoTracking();      

?>