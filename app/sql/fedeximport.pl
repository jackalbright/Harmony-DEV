#!/usr/bin/perl
#

use Data::Dumper;

($csv, $shippingMethod) = @ARGV; # Ground.csv 1 == ground, etc.
if (!$shippingMethod) { print "$0 <file.csv> <shippingMethodID>\n"; exit(1); }

open(PRICING, "<$csv");

%zone_costs = ();

while($line = <PRICING>)
{
	chomp($line);
	@fields = split(",", $line);
	if ($fields[0] eq 'Weight')
	{
		shift(@fields);
		#print Dumper(\@fields);
		#@zones = @fields;
		@zones = map { $_ =~ s/Zone //; $_ =~ s/\s+//g; $_; } @fields;
		#print Dumper(\@zones);
	} elsif ($fields[0] =~ /\d/) {
		my $weight = shift(@fields);
		@costs = map { $_ =~ s/\$//; $_ =~ s/\s+//; $_; } @fields;
		if ($weight =~ /(\-|\+)/) { next; } # Too heavy, whatever....

		for($z = 0; $z < @zones; $z++)
		{
			$zone = $zones[$z];
			@zoneab = split("-", $zone);
			#print "Z=". Dumper \@zones;
			if (scalar(@zoneab) > 1)
			{
				for($za = $zones[0]; $za <= $zones[1]; $za++)
				{
					if ($costs[$za] ne '-')
					{
						print "UPDATE shippingPricePoint SET cost = '$costs[$za]' WHERE weight = '$weight' AND zoneNumber = '$za' AND shippingMethod = '$shippingMethod';\n";
					}
				}
			} else {
				if ($costs[$z] ne '-')
				{
					print "UPDATE shippingPricePoint SET cost = '$costs[$z]' WHERE weight = '$weight' AND zoneNumber = '$zone' AND shippingMethod = '$shippingMethod';\n";
				}
			}

		}
	}
}

