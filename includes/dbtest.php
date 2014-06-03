<html><body>
<? 
include("./database.inc");

$products = get_db_records("product_type");

foreach($products as $p)
{
	echo $p['name'];
	?>
	<br/>
	<?
}

?>
</body>
</html>
