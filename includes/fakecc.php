<?
header("Content-Type: text/plain");

$fnames = array(
"John",
"Adam",
"Tom",
"Allison",
"Amy",
"Jim",
"Anna",
"Jennifer",
"Albert"
);

$lnames = array(
"Johnson",
"Morrison",
"Webster",
"Pearson",
"Blake",
"Lawrence",
"Torres",
"Lopez",
"Buscaglia"
);
$states = array(
"CA",
"WA",
"MD",
"PA",
"NJ"
);
$cities = array(
"Springfield",
"Knoxville",
"Atlanta",
"San Francisco",
"New York",
"Washington"
);
$streets = array(
"Wondershine Rd",
"Alloway Blvd",
"Traverson St",
"9th St",
"17th Ave",
"Wallowson Ave"
);

for($i = 0; $i < 500; $i++)
{
	$fname = $fnames[array_rand($fnames)];
	$lname = $lnames[array_rand($lnames)];
	$city = $cities[array_rand($cities)];
	$state = $states[array_rand($states)];
	$street = $streets[array_rand($streets)];
	$cc = sprintf("4%03d%04d%04d%04d", rand(0,999), rand(0,9999), rand(0,9999), rand(0,9999));
	$zip = sprintf("%05d", rand(0,99999));
	$housenum = sprintf("%04d", rand(0,9999));

	echo "$fname, $lname, $housenum, $street, $city, $state, $zip, $cc\n";
}

?>
