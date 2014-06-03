<? $this->element("steps/steps",array('step'=>'layout')); ?>
<div align="center">
	<table width="100%">
	<tr>
		<td align="center" width="25%">
			<h4 class="alert2">Image and Text</h4>
		</td>
		<? if(!empty($build['Product']['image_only'])) { ?>
		<td align="center" width="25%">
			<h4 class="alert2">Image Only</h4>
		</td>
		<? } ?>
		<td align="left">
			<h4 class="alert2">
				Other Layout
			</h4>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<a rel="shadowbox" href="/product_image/build_view/-900x650.png?rand=<?= rand() ?>&template=standard">
				<img src="/product_image/build_view/-300x300.png?rand=<?= rand() ?>&template=standard"/>
			</a>
			<br/>
			<a rel="shadowbox" href="/product_image/build_view/-900x650.png?rand=<?= rand() ?>&template=standard">+ View Larger</a>
			<br/>
			<br/>
			<a rel="shadowbox;width=700;height=600" href="/build/crop/standard">Adjust your image</a>
		</td>
		<? if(!empty($build['Product']['image_only'])) { ?>
		<td width="25%" valign="middle" align="center">
			<a rel="shadowbox" href="/product_image/build_view/-900x650.png?rand=<?= rand() ?>&template=imageonly">
				<img src="/product_image/build_view/-300x300.png?rand=<?= rand() ?>&template=imageonly"/>
			</a>
			<br/>
			<a rel="shadowbox" href="/product_image/build_view/-900x650.png?rand=<?= rand() ?>&template=imageonly">+ View Larger</a>
			<br/>
			<br/>
			<a rel="shadowbox;width=700;height=600" href="/build/crop/imageonly">Adjust your image</a>
		</td>
		<? } ?>
		<td valign="top" align="left">

			<p>

			</p>

			<ul>
				<li>
					Have a "press-ready" design?
				</li>
				<li>
					Have a text-only design?
				</li>
				<li>
					Need to discuss your project before continuing?
				</li>
				<li>
					Want to continue your order offline?
				</li>
				<li>
					Other questions? <b>888.293.1109</b>
				</li>
			</ul>
			<br/>
			<br/>
			<!--
			<p class="bold">
				Click below to email your design as an attachment
			</p>
			-->
		</td>
	</tr>
	<tr>
		<td align="center">
			<form method="GET" action="/build/customize">
				<input type="hidden" name="prod" value="<?= $build['Product']['code'] ?>"/>
				<input type="hidden" name="catalog_number" value="<?= !empty($build['GalleryImage']['stamp_number']) ? $build['GalleryImage']['stamp_number'] : null ?>"/>
				<input type="hidden" name="image_id" value="<?= !empty($build['CustomImage']['Image_ID']) ? $build['CustomImage']['Image_ID'] : null ?>"/>
				<input type="hidden" name="template" value="standard"/>
				<input type="image" src="/images/buttons/Select.gif"/>
			</form>
		</td>
		<? if(!empty($build['Product']['image_only'])) { ?>
		<td align="center">
			<form method="GET" action="/build/customize">
				<input type="hidden" name="prod" value="<?= $build['Product']['code'] ?>"/>
				<input type="hidden" name="catalog_number" value="<?= !empty($build['GalleryImage']['stamp_number']) ? $build['GalleryImage']['stamp_number'] : null ?>"/>
				<input type="hidden" name="image_id" value="<?= !empty($build['CustomImage']['Image_ID']) ? $build['CustomImage']['Image_ID'] : null ?>"/>
				<input type="hidden" name="template" value="imageonly"/>
				<input type="image" src="/images/buttons/Select.gif"/>
			</form>
		</td>
		<? } ?>
		<td align="left">
		</td>
	</tr>
	</table>
</div>
