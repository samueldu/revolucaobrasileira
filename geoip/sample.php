#!/usr/bin/php -q
<?php

// This code demonstrates how to lookup the country by IP Address
include("geoip.inc");

// Uncomment if querying against GeoIP/Lite City.
include("geoipcity.inc");
include("geoipregionvars.php");

$gi = geoip_open("GeoLiteCity.dat",GEOIP_STANDARD);

$_SERVER['REMOTE_ADDR'] = "187.59.146.110";

$record = geoip_record_by_addr($gi, $_SERVER['REMOTE_ADDR']);

print $GEOIP_REGION_NAME[$record->country_code][$record->region]." ".$record->city;

geoip_close($gi);

print $record->country_code . " " . $record->country_code3 . " " . $record->country_name . "\n";
print $record->region . " " . $GEOIP_REGION_NAME[$record->country_code][$record->region] . "\n";
print $record->city . "\n";
print $record->postal_code . "\n";
print $record->latitude . "\n";
print $record->longitude . "\n";
print $record->metro_code . "\n";
print $record->area_code . "\n";
geoip_close($gi);

print $GEOIP_REGION_NAME[$record->country_code][$record->region]." ".$record->city;

?>
