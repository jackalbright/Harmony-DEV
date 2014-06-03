	<div style="" class="relative <?= (empty($malysoft) && empty($hdtest)) ? "hidden" : "" ?>">
		<? $specialties = get_db_records("specialty_pages", "enabled = 1", "sort_index ASC, link_name ASC, page_title ASC"); ?>
		<div id="specialties_all" class="hidden">

			<div class="specialties_tabs">
			<a class="close" href="Javascript:void(0);" onClick="$('specialties_all').addClassName('hidden');">[CLOSE]</a>
			<div class="clear"></div>

			<? for($i = 0; $i < count($specialties); $i++) { $spec = $specialties[$i]; ?>
				<? if($i > 0) { ?><a>&bull;</a><? } ?>
				<a href="/specialty_pages/view/<?= $spec['page_url'] ?>"><?= !empty($spec['link_name']) ? $spec['link_name'] : $spec['page_title'] ?></a>
			<? } ?>
			<div class="clear"></div>
			</div>
		</div>
		<div id="specialties_nav_top" class="specialties_nav">
			<table width="100%" cellpadding=0 cellspacing=0 class="specialties_tabs">
			<tr>
				<td width="75">
					<div class='bold black nounderline' style="color: black !important;">Specialties:</div>
				</td>
				<td class="">
					<? for($i = 0; $i < 5 && $i < count($specialties); $i++) { $spec = $specialties[$i]; ?>
						<div class="left"><?= $i > 0 ? " &bull; " : "" ?><a href="/specialty_pages/view/<?= $spec['page_url'] ?>"><?= !empty($spec['link_name']) ? $spec['link_name'] : $spec['page_title'] ?></a></div>
					<? } ?>
				</td>
				<td align="right">
					<a class="view_all" href="Javascript:void(0);" onClick="$('specialties_all').removeClassName('hidden');">View All &raquo;</a>
				</td>
			</tr>
			</table>
		</div>
	</div>

