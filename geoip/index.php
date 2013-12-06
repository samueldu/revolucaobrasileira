<?php
//if(!isset($_SESSION['regiao']))
//{
    // This code demonstrates how to lookup the country by IP Address
    include(DIR_SYSTEM."../geoip/geoip.inc");

    // Uncomment if querying against GeoIP/Lite City.
    include(DIR_SYSTEM."../geoip/geoipcity.inc");
    include(DIR_SYSTEM."../geoip/geoipregionvars.php");

    $gi = geoip_open(DIR_SYSTEM."../geoip/GeoLiteCity.dat",GEOIP_STANDARD);

    if(ambient=="local")
    $_SERVER['REMOTE_ADDR'] = "187.59.146.110";

    $record = geoip_record_by_addr($gi, $_SERVER['REMOTE_ADDR']);

    switch($GEOIP_REGION_NAME[$record->country_code][$record->region])
    {
        case "Parana":
            $sigla = "PR";
            $nome = "Paraná";
            $conector = "no";
            break;
        case "Sao Paulo":
            $sigla = "SP";
            $nome = "São Paulo";
            $conector = "em";
            break;
        case "Rio de Janeiro":
            $sigla = "RJ";
            $nome = "Rio";
            $conector = "no";
            break;
    }

    define("estado_sigla",$sigla);
    define("cidade",$record->city);
    define("estado_nome",$nome);
    define("conector",$conector);
//}
?>