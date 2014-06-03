<div id="howToOrder" class="">
	<div class="right italic">
		Click on a screen to view larger
	</div>
	<div>
		<span class="howto">How to order</span>
		<span class="easysteps"> in 3 easy steps</span>
	</div>
	<div class="clear"></div>

	<div id="white_box" class="">
		<table class="steps" cellpadding=0 cellspacing=0 border=0>
		<tr>
			<td class="step step1">
				<a title="Click to view larger" href="/images/how_to_order/screenshots/upload.png">
				<table cellpadding=0 cellspacing=0><tr><td>
					<img src="/images/how_to_order/screenshots/small/upload.png"/>
				</td></tr></table>
				</a>
			</td>
			<td class="arrow">
				<img src="/images/how_to_order/arrow.png"/>
			</td>
			<td class="step step2">
				<?
					$buildprefix = file_exists(APP."/../images/how_to_order/screenshots/build-$prod.png") ?
						"build-$prod" : "build";
				?>
				<a title="Click to view larger" href="/images/how_to_order/screenshots/<?= $buildprefix ?>.png">
				<table cellpadding=0 cellspacing=0><tr><td>
					<img src="/images/how_to_order/screenshots/small/<?= $buildprefix ?>.png"/>
				</td></tr></table>
				</a>
			</td>
			<td class="arrow">
				<img src="/images/how_to_order/arrow.png"/>
			</td>
			<td class="step step3">
				<?
					$cartprefix = file_exists(APP."/../images/how_to_order/screenshots/cart-$prod.png") ?
						"cart-$prod" : "cart";
				?>
				<a title="Click to view larger" href="/images/how_to_order/screenshots/<?= $cartprefix ?>.png">
				<table cellpadding=0 cellspacing=0><tr><td>
					<img src="/images/how_to_order/screenshots/small/<?= $cartprefix ?>.png"/>
				</td></tr></table>
				</a>
			</td>
		</tr>
		<tr>
			<td class="label">
				1. Upload art, logo, photo
			</td>
			<td>&nbsp;</td>
			<td class="label">
				2. Select your options
			</td>
			<td>&nbsp;</td>
			<td class="label">
				3. Add to cart
			</td>
		</tr>
		</table>
	</div>

	<div class="previewnow">Preview and order your custom products online now!</div>

	<div class="get_started">
		<a href="/custom_images"><img src="/images/buttons/Get-Started.gif"/></a>
	</div>
</div>
<style>
.HowToOrder
{
	background: url("/images/how_to_order/periwinkle-box.png") no-repeat;
	position: relative;
	border: 0px;
}

.HowToOrder #modal
{
	width: 960px;
	padding: 25px;
	height: 560px;

	color: white;
}
.HowToOrder .ui-dialog-titlebar
{
	position: absolute;
	z-index: 899;
	top: 10px;
	right: 15px;
	background: none;
	border: none;
}
.HowToOrder .ui-dialog-titlebar .ui-dialog-title
{
	display:none;
}
.HowToOrder .ui-widget-header .ui-icon
{
	background-image: url("/css/flick/images/ui-icons_ffffff_256x240.png");
}
.HowToOrder .ui-widget-header a.ui-dialog-titlebar-close.ui-state-hover
{
	border-color: #CCC;
	background: #CCC;
}

.HowToOrder .ui-widget-header a.ui-dialog-titlebar-close.ui-state-hover .ui-icon
{
	background-color: #CCC;
	border-color: #CCC;
}
.HowToOrder .howto
{
	font-size: 32px;
}

.HowToOrder .easysteps, .HowToOrder .previewnow
{
	padding-left: 15px;
	font-size: 24px;
	font-style: italic;
}
.HowToOrder .previewnow
{
	text-align: center;
}
.HowToOrder #white_box
{
	margin-top: 10px;
	color: #000;
	width: 900px;
	height: 300px;
	margin: 0 auto;
	padding: 3px;
	padding-top: 25px;
	background: url("/images/how_to_order/white-box.png") no-repeat;
}

.HowToOrder .get_started
{
	margin: 20px auto;
	text-align: center;
}


.HowToOrder .steps
{
	height: 185px;
}


.HowToOrder .arrow
{
	width: 35px;
	text-align: center;
	vertical-align: middle;
}
.HowToOrder .label
{
	padding: 5px;
	text-align: center;
	font-weight: bold;
}

.HowToOrder .step
{
	text-align: left;
	vertical-align: top;
	width: 250px;
	height: 230px;
	padding: 11px;
	background: #FFFFEE url("/images/how_to_order/monitor.png") no-repeat;
}

.HowToOrder .step a
{
	position: relative;
	top: 0px;
	left: 0px;
	display: block;
	width: 248px;
	height: 150px;
	overflow: hidden;
	/* restrict width/height to proportions of monitor */
}

.HowToOrder .step a table
{
	width: 100%;
	height: 150px;
}
.HowToOrder .step a table td
{
	vertical-align: middle;
}

.HowToOrder .step a img
{
	display: block;
	position: relative;
}


</style>
<script>
Shadowbox.setup('.step1 a', { title: 'How To Order: Step 1. Upload art, logo, photo' });
Shadowbox.setup('.step2 a', { title: 'How To Order: Step 2. Select your options' });
Shadowbox.setup('.step3 a', { title: 'How To Order: Step 3. Add to cart' });

/*
console.log("SCREIPT");
j('#howToOrder .step a').click(function() { return false; });

j('#howToOrder .step a img').load(function() { j(this).show(); 
	if(j(this).closest('a').hasClass('zoomed'))
	{ // start up proper position
		moveZoom(this, e); // go to where mouse is, relatively.
	}

});

j('#howToOrder .step a').hover(function(e) {
	console.log("OVER");
	var href = j(this).attr('href');
	var img = j(this).find('img');
	img.hide();
	img.data('src', img.prop('src'));
	
	img.prop('src', href); // zoom in.
	j(this).addClass('zoomed');

}, function() { // out
	console.log("OUT");
	j(this).removeClass('zoomed');

	var img = j(this).find('img');
	img.hide();
	img.prop('src', img.data('src'));
	img.css({top: 0, left: 0});
});
j('#howToOrder .step a').mousemove(function(e) {
	moveZoom(this, e);
});

function moveZoom(link, e)
{
	if(!j(link).hasClass("zoomed")) { return; }
	var mouseX = e.pageX;
	var mouseY = e.pageY;

	var myX = j(link).offset().left;
	var myY = j(link).offset().top;
	var myW = parseInt(j(link).css('width'));
	var myH = parseInt(j(link).css('height'));

	//console.log("MY="+myX+", "+myY+"; MOUSE="+mouseX+", "+mouseY);

	var relX = mouseX - myX;
	var relY = mouseY - myY;

	var percentX = parseInt(relX / myW * 100);
	var percentY = parseInt(relY / myH * 100);

	//console.log(percentX+" , "+percentY);

	var img = j(link).find('img');

	var imgW = parseInt(img.css('width'));
	var imgH = parseInt(img.css('height'));

	var posX = parseInt(imgW*percentX/100);
	var posY = parseInt(imgH*percentY/100);

	//console.log("POSX,Y="+posX+", "+posY);

	img.css({top: "-"+posY+"px", left: "-"+posX+"px"});
}
*/
</script>
