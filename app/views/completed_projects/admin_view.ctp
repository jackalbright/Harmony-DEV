<div class="completedProjects view">
<h2><?php  __('Completed Image');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedProject['CompletedProject']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Company'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedProject['CompletedProject']['company']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Account Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= !empty($completedProject['CompletedProject']['wholesale_customer']) ? "Wholesale/Reseller" : "Personal/Retail" ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedProject['CompletedProject']['full_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= $this->Html->link(
				$completedProject['CompletedProject']['email'],
				"mailto:".$completedProject['CompletedProject']['email'],
				array()); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Session'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= $this->Html->link($completedProject['CompletedProject']['session_id'],
				"/admin/tracking_requests/session/".$completedProject['CompletedProject']['session_id'],
				array()); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedProject['CompletedProject']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedProject['CompletedProject']['address']; ?><br/>
			<?php echo $completedProject['CompletedProject']['city']; ?>, <?php echo $completedProject['CompletedProject']['state']; ?><br/>
			<?php echo $completedProject['CompletedProject']['zip_code']; ?><br/>
			<?php echo $completedProject['CompletedProject']['country']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($completedProject['Product']['long_name'], array('controller' => 'products', 'action' => 'view', $completedProject['Product']['product_type_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedProject['CompletedProject']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Services Needed'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= !empty($completedProject['CompletedProject']['free_consultation']) ? "Free consultation<br/>":"" ?>
			<?= !empty($completedProject['CompletedProject']['free_email_proof']) ? "Free email proof<br/>":"" ?>
			<?= !empty($completedProject['CompletedProject']['proof_without_order']) ? "Proof without order<br/>":"" ?>
			<?= !empty($completedProject['CompletedProject']['free_quote']) ? "Free quote<br/>":"" ?>
			<? $printing_back = $completedProject['CompletedProject']['printing_on_back']; ?>
			<? if($printing_back == 'same') { ?>
				Print on two sides &ndash; Same art both sides
			<? } else if($printing_back == 'different') { ?>
				Print on two sides &ndash; Different art on each side
			<? } else { ?>
				Print on one side
			<? } ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Needed By'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= date("m/d/Y", strtotime($completedProject['CompletedProject']['needed_by'])); ?>
			<?= $completedProject['CompletedProject']['needed_by_strict'] ? "<b>Strict deadline</b>" : ""; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Comments'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedProject['CompletedProject']['comments']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Artwork'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<? if(!empty($completedProject['CompletedImage'][0]['path'])) { ?>
			<b>Side 1:</b><br/>
			<a href="/<?= $completedProject['CompletedImage'][0]['path'] ?>/<?= $completedProject['CompletedImage'][0]['filename'] ?>">
				<img style="max-height: 250px;" src="/<?= $completedProject['CompletedImage'][0]['path'] ?>/<?= $completedProject['CompletedImage'][0]['filename'] ?>"/>
			</a>
			<br/>
			<a href="/<?= $completedProject['CompletedImage'][0]['path'] ?>/<?= $completedProject['CompletedImage'][0]['filename'] ?>">
				/<?= $completedProject['CompletedImage'][0]['path'] ?>/<?= $completedProject['CompletedImage'][0]['filename'] ?>
			</a>
			<? } ?>
			<br/>

			<? if(!empty($completedProject['CompletedImage'][1]['path'])) { ?>
			<b>Side 2:</b><br/>
			<a href="/<?= $completedProject['CompletedImage'][1]['path'] ?>/<?= $completedProject['CompletedImage'][1]['filename'] ?>">
				<img style="max-height: 250px;" src="/<?= $completedProject['CompletedImage'][1]['path'] ?>/<?= $completedProject['CompletedImage'][1]['filename'] ?>"/>
			</a>
			<br/>
			<a href="/<?= $completedProject['CompletedImage'][1]['path'] ?>/<?= $completedProject['CompletedImage'][1]['filename'] ?>">
				/<?= $completedProject['CompletedImage'][1]['path'] ?>/<?= $completedProject['CompletedImage'][1]['filename'] ?>
			</a>
			<? } ?>

		</dd>
	</dl>
</div>
