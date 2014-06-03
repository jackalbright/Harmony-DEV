<?
/* Removing image # so faster page load.
$saved_img_count = 0;

$customer_id = !empty($_SESSION['Auth']['Customer']['customer_id']) ? $_SESSION['Auth']['Customer']['customer_id'] : null;

if ($customer_id)
{
	$saved_images = get_db_record("custom_image", array(" customer_id = '$customer_id' "), null, array("COUNT(*) AS count"));
	$saved_img_count = $saved_images['count'];
}

$unsaved_img_count = 0;
$session_id = session_id();
$unsaved_images = get_db_record("custom_image", array(" customer_id IS NULL AND session_id = '$session_id' "), null, array("COUNT(*) AS count"));
$unsaved_img_count = $unsaved_images['count'];

$img_count = $saved_img_count + $unsaved_img_count;
*/
?>
	<script>
	var myImagesLoaded = false;
	</script>
	<!--<a style="color: #009900; font-weight: bold;" href="/custom_images/index/reset" XonMouseOver="if(!myImagesLoaded) { loadMyImages(); myImagesLoaded = true; }">My Images</a> <?= !empty($img_count) ? "($img_count)" : "" ?>-->
	<a style="color: #009900; font-weight: bold;" href="/custom_images/index/reset">My Images</a>

