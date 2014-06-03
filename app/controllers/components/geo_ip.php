<?php

// Get original here: http://www.maxmind.com/download/geoip/api/php/sample_city.php
// Modified by Drew Yeaton, Sentinel Design Group, (http://www.sentineldesign.net/)

class GeoIpComponent extends Object {
    function lookupIp($ip) {
        App::import("Vendor", "geoipcity");

        $gi = geoip_open(APP."/webroot/files/GeoLiteCity.dat", GEOIP_STANDARD);
        $result = geoip_record_by_addr($gi, $ip);
        geoip_close($gi);
	if(empty($result)) { return array(); }
        
        return get_object_vars($result);
    }
    
    function findIp() {
      if(getenv("HTTP_CLIENT_IP"))
        return getenv("HTTP_CLIENT_IP"); 
      elseif(getenv("HTTP_X_FORWARDED_FOR"))
        return getenv("HTTP_X_FORWARDED_FOR"); 
      else 
        return getenv("REMOTE_ADDR"); 
    }
}

?>
