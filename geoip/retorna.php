<?

/**/
error_reporting(E_ALL);
ini_set('display_errors', 'on');
    ini_set("memory_limit", "4000M");
    ini_set('max_execution_time','100000000000000000000000000000000');
    set_time_limit('100000000000000000000000000000000');
    flush();
/**/

function pegaGeoTracking($ip)
        {
            // This code demonstrates how to lookup the country by IP Address
            require_once("geoip.inc");
            require_once("geoipcity.inc");
            require_once("geoipregionvars.php");

            $gi = geoip_open("GeoLiteCity.dat",GEOIP_STANDARD);

            $record = geoip_record_by_addr($gi, $ip);
            
            $dados['pais'] = $record->country_code;
            $dados['estado'] = $GEOIP_REGION_NAME[$record->country_code][$record->region];
            $dados['cidade'] = $record->city;
            
            print $ip."<BR>";
            
            print $record->country_code . " " . $record->country_code3 . " " . $record->country_name . "\n";
            print $record->region . " " . $GEOIP_REGION_NAME[$record->country_code][$record->region] . "\n";
            print $record->city . "\n";
            print $record->postal_code . "\n";
            print $record->latitude . "\n";
            print $record->longitude . "\n";
            print $record->metro_code . "\n";
            print $record->area_code . "\n";
            
            geoip_close($gi);      
            return $dados; 
        }
        
        //if (getenv(HTTP_X_FORWARDED_FOR))
        //{
           // $ip = getenv(HTTP_X_FORWARDED_FOR);
       // }
       // else
        //{
            $ip = getenv(REMOTE_ADDR);
        //} 
        /*    
        $ip = $_SERVER['REMOTE_ADDR'];
        $ip = "189.114.233.179";
        */
        
        //print_r($_SERVER);
        
        $return = pegaGeoTracking($ip);
        
        print "<BR><BR>meu ip � : - $ip";
?>