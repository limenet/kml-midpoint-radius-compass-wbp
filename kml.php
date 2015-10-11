<?php
if (!empty($_POST)) {
    $angles = [];
    $angles[0] = mt_rand(0, 89); // get first angle, within 1st quadrant
    for ($i = 1; $i < 4; $i++) {
        $angles[$i] = $angles[$i - 1] + 90;
    }

    $directions = ['North', 'East', 'South', 'West'];

    $points = [];
    $o = explode(',', $_POST['origin']);
    $origin = ['lat' => trim($o[0]), 'lon' => trim($o[1])];

    $distance = 10; //km
    foreach ($angles as $i => $bearing) {

        //http://www.movable-type.co.uk/scripts/latlong.html

        $lat1 = deg2rad($origin['lat']);
        $lon1 = deg2rad($origin['lon']);
        $d = $distance / 6371;  // convert dist to angular distance in radians
        $b = deg2rad($bearing);
        $lat2 = asin(sin($lat1) * cos($d) + cos($lat1) * sin($d) * cos($b));
        $lon2 = $lon1 + atan2(sin($b) * sin($d) * cos($lat1), cos($d) - sin($lat1) * sin($lat2));
        //$lon2 = ($lon2+3*pi()) % (2*pi()) - pi();  // normalise to -180..+180º
        $points[$i] = ['lat' => rad2deg($lat2), 'lon' => rad2deg($lon2)];
    }
    $file = '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
<Document>
<name>4 random angles from '.implode(', ', $origin).'</name>
<open>1</open>
<Placemark>
<name>'.implode(', ', $origin).' [origin]</name>
<Point>
<coordinates>'.PHP_EOL;
    $file .= implode(',', array_reverse($origin)).',0';
    $file .= '
</coordinates>
</Point>
</Placemark>'.PHP_EOL;
    foreach ($points as $i => $point) {
        $file .= '<Placemark>
        <name>Line '.$directions[$i].'</name>
        <LineString>
        <tessellate>1</tessellate>
        <altitudeMode>clampToGround</altitudeMode>
        <coordinates>'.PHP_EOL;
        $file .= implode(',', array_reverse($origin)).',0'.' '.implode(',', array_reverse($point)).',0'.' ';
        $file .= '
        </coordinates>
        </LineString>
        </Placemark>'.PHP_EOL;
    }
    $file .= '
</Document>
</kml>'.PHP_EOL;
}
ob_clean();
flush();
header('Content-Type: text/kml');
header('Content-Disposition: attachment; filename=Lines__'.implode('_', $origin).'.kml');
header('Expires: 0');
echo($file);
?>

