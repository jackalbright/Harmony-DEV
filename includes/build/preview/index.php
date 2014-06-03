<div id="build_preview">
<h4 class="sidebar_header">Currently Building:</h4>
<!--<div class="right_align">[<a href="/?start_over=1">Start Over</a> | <a href="/build/save">Save For Later</a>]</div>-->
<div class="right_align">[<a href="/?start_over=1">Start Over</a>]</div>

<? 
if (false)
{
include(dirname(__FILE__)."/product_preview.php"); product_preview($build); 
}
?>
<hr/>
<? include(dirname(__FILE__)."/image.php"); ?>

<? include(dirname(__FILE__)."/product.php"); ?>

</div>
