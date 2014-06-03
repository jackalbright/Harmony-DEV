#!/usr/bin/perl
#

$header = <>;
chomp($header);
@keys = split(",", $header);
shift(@keys);

while($line = <>)
{
	chomp($line);
	@values = split(",", $line);
	$weight = shift(@values);
	for($i = 0; $i < @values; $i++)
	{
		print "INSERT INTO shippingPricePoint (shippingMethod,zoneNumber,weight,cost) VALUES(10,$keys[$i],$weight,$values[$i]);\n";
	}


}
