<div class='widget'>
	<h3><!--<img src="/images/icons/small/request-icon-grey.png"/>-->Learn More</h3>
<div class="standard_sidebar_container" >
	<ul class="standard_sidebar_list">
		<!--<li> <a class="" rel="shadowbox;type=html;width=625;height=625" href="/specialty_page_prospects/add">Wholesale Account</a></li>-->
		<? if(preg_match("/custom/", $product['Product']['image_type'])) { ?>
			<li> <a id="download_template" href="/products/template/<?= $prod ?>">Template &amp; Specifications</a></li>
		<? } ?>
		<? if(!in_array($prod, array('B',"BB","BNT","BC")) && empty($product['Product']['is_stock_item'])) { ?>
		<!--
		<li> <a rel="shadowbox;type=html;width=625;height=625" href="/sample_requests/add/<?= $prod ?>">Free Random Sample</a></li>
		-->
		<? } ?>
		<li> <a Xrel="shadowbox;type=html;width=625;height=625" class='modal' href="/quote_requests/add/<?= $prod ?>">Price Quote (RFQ)</a></li>

		<li> <a href="mailto:info@harmonydesigns.com">Email Questions</a>
		<li> Free Consult: 888.293.1109
	</ul>

    </div><!--standard_sidebar_container-->
</div><!--widget-->

<? if(empty($wholesale_site)) { ?>
<div class='widget'>
    <h3 >Specialties</h3>
    <div class="standard_sidebar_container">
        <ul class='standard_sidebar_list'>
            <li> 
                <a class="modal" style="" Xrel="shadowbox;type=html;width=800;height=800" href="/specialty_page_prospects/add/Education"><?= empty($snippet_titles['Education_form']) ? "Education" : $snippet_titles['Education_form'] ?></a>
            <li> 
                <a class="modal" style="" Xrel="shadowbox;type=html;width=800;height=800" href="/specialty_page_prospects/add/HealthCare"><?=  empty($snippet_titles['HealthCare_form']) ? "Healthcare" : $snippet_titles['HealthCare_form'] ?></a>
            <li> 
                <a class="modal" style="" Xrel="shadowbox;type=html;width=800;height=800" href="/specialty_page_prospects/add/museum"><?= $snippet_titles['museum_form'] ?></a>
            <li> 
                <a class="modal" style="" Xrel="shadowbox;type=html;width=800;height=800" href="/specialty_page_prospects/add/GovernmentOrders"><?= $snippet_titles['GovernmentOrders_form'] ?></a>
            <li> 
                <a class="modal" style="" href="/specialty_page_prospects/add"><?= $snippet_titles['wholesale_form'] ?></a>
        </ul>
    </div><!--standard_sidebar_container-->
</div><!--widget-->
<? } ?>







	<script>
	j('#download_template').click(function (e) {
		var href = j(this).prop('href');
		e.stopPropagation();
		j('#modal').load(href, null, function()
		{
			j('#modal').dialog({
				width: 700,
				title: 'Download Template(s)',
				modal: true,
				resizable: false,
				draggable: false
			});

			j('.ui-widget-overlay').click(function() {
				j('#modal').dialog('close');
			});
		})

		return false;

	});
	</script>


