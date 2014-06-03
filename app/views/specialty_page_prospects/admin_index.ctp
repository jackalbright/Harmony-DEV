<div class="right_align">
	<form method="POST" action="/admin/specialty_page_prospects">
	Search: 

	<select name="data[field]" id="field">
		<option value="name">Full Name</option>
		<option value="email">Email</option>
		<option value="company">Company</option>
        <option value="state">State</option>
        <option value="zipcode">Zip Code</option>
	</select>
	<?= $javascript->codeBlock("Event.observe(window, 'load', function() { \$('field').value = '". $this->data['field'] ."'; });"); ?>
	
	<input type="text" name="data[value]" value="<?= $this->data['value'] ?>"/>
	<input type="submit" value="Search"/>
	<a href="/admin/account">View All</a>
	</form>
</div>
<h3>TestVariable <?php print_r($testVariable)?></h3>
<div>
<p> <?php echo $paginator->counter(array( 'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))); ?></p>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>

<table cellpadding="0" cellspacing="0" class="admin_specialtyInquiryTable">
<thead>
<tr class="tableHeading">
	<th>ID</th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('organization');?></th>
    <th><?php echo $paginator->sort('city');?></th>
    <th><?php echo $paginator->sort('state');?></th>
     <th><?php echo $paginator->sort('zipcode');?></th>
    <th><?php echo $paginator->sort('email');?></th>
    <th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('type');?></th>
	<!--<th><?php echo $paginator->sort('specialty_page_id');?></th>-->
	<th><?php echo $paginator->sort('want_quote');?></th>
	<th><?php echo $paginator->sort('want_catalog');?></th>
	<th><?php echo $paginator->sort('want_consultation');?></th>
	<th><?php echo $paginator->sort('want_sample');?></th>
</tr>
</thead>
<tfoot>
</tfoot>
<? $i = 0; foreach ($specialtyPageProspects as $specialtyPageProspect) { $i++; ?>
<tr class="<?= $i % 2 == 0 ? "altrow" : "" ?>">
	<td>
			<a href="/admin/specialty_page_prospects/view/<?= $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'] ?>">
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id']; ?>
			</a>
		</td>



		<td>
			<a href="/admin/specialty_page_prospects/view/<?= $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'] ?>">
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['name']; ?>
			</a>
		</td>
        <!--The Person's Organization-->
		<td>
			<a href="/admin/specialty_page_prospects/view/<?= $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'] ?>">
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['organization']; ?>
			</a>
		</td>
       <!--The Person's City-->
		<td>
			<a href="/admin/specialty_page_prospects/view/<?= $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'] ?>">
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['city']; ?>
			</a>
		</td> 
               <!--The Person's State-->
		<td>
			<a href="/admin/specialty_page_prospects/view/<?= $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'] ?>">
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['state']; ?>
			</a>
		</td>
               <!--The Person's Zipcode-->
		<td>
			<a href="/admin/specialty_page_prospects/view/<?= $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'] ?>">
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['zipcode']; ?>
			</a>
		</td> 
                       <!--The Person's Email Address-->
		<td>
			
			<a href='mailto:<?php echo $specialtyPageProspect['SpecialtyPageProspect']['email']; ?>'>
            <?php echo $specialtyPageProspect['SpecialtyPageProspect']['email']; ?> /a>
			
		</td>          
        <!-- Date and Time that the record was created-->
        	<td>
			<a href="/admin/specialty_page_prospects/view/<?= $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'] ?>">
			<?php echo date("F n, Y - h:ia",strtotime($specialtyPageProspect['SpecialtyPageProspect']['created'])); ?>
			</a>
		</td>
        
        <!--The Prospect Type (Education, Government, Healthcare, etc)-->
		<td class="inquiryType">
			<?= $specialtyPageProspect['SpecialtyPageProspect']['type'] ?>
		</td>
        
		<!--<td>
			<?= !empty($specialtyPageProspect['SpecialtyPage']['link_name']) ? $specialtyPageProspect['SpecialtyPage']['link_name'] : $specialtyPageProspect['SpecialtyPage']['page_title']; ?>
		</td>-->
		<td class="checkmark">
			<?= !empty($specialtyPageProspect['SpecialtyPageProspect']['want_quote']) ? "<img src='/images/icons/check.png'/>" : "" ?><br/>
		</td>
		<td class="checkmark">
			<?= !empty($specialtyPageProspect['SpecialtyPageProspect']['want_catalog']) ? "<img src='/images/icons/check.png'/>" : "" ?><br/>
		</td>
		<td class="checkmark">
			<?= !empty($specialtyPageProspect['SpecialtyPageProspect']['want_consultation']) ? "<img src='/images/icons/check.png'/>" : "" ?><br/>
		</td>
		<td>
			<?= !empty($specialtyPageProspect['SpecialtyPageProspect']['want_sample']) ? "<img src='/images/icons/check.png'/>" : "" ?><br/>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample1']; ?><br/>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample2']; ?><br/>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample3']; ?>
		</td>
</tr>
<? } ?>
</table>



</div>

<hr/>

<div class="specialtyPageProspects index hidden">
<h2><?php __('SpecialtyPageProspects');?></h2>
<p> <?php echo $paginator->counter(array( 'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))); ?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('specialty_page_prospects_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('organization');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th><?php echo $paginator->sort('phone');?></th>
	<th><?php echo $paginator->sort('address1');?></th>
	<th><?php echo $paginator->sort('address2');?></th>
	<th><?php echo $paginator->sort('city');?></th>
	<th><?php echo $paginator->sort('state');?></th>
	<th><?php echo $paginator->sort('zipcode');?></th>
	<th><?php echo $paginator->sort('sample1');?></th>
	<th><?php echo $paginator->sort('sample2');?></th>
	<th><?php echo $paginator->sort('sample3');?></th>
	<th><?php echo $paginator->sort('project_details');?></th>
	<th><?php echo $paginator->sort('want_quote');?></th>
	<th><?php echo $paginator->sort('want_catalog');?></th>
	<th><?php echo $paginator->sort('want_consultation');?></th>
	<th><?php echo $paginator->sort('want_sample');?></th>
	<th><?php echo $paginator->sort('specialty_page_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($specialtyPageProspects as $specialtyPageProspect):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['name']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['organization']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['email']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['phone']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['address1']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['address2']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['city']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['state']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['zipcode']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample1']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample2']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample3']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['project_details']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_quote']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_catalog']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_consultation']; ?>
		</td>
		<td>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_sample']; ?>
		</td>
		<td>
			<?php echo $html->link($specialtyPageProspect['SpecialtyPage']['specialty_page_id'], array('controller'=> 'specialty_pages', 'action'=>'view', $specialtyPageProspect['SpecialtyPage']['specialty_page_id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New SpecialtyPageProspect', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Specialty Pages', true), array('controller'=> 'specialty_pages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Specialty Page', true), array('controller'=> 'specialty_pages', 'action'=>'add')); ?> </li>
	</ul>
</div>
