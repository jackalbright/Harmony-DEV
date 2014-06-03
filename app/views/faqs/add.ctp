<div class="faqRequests form">
	<b>Can't find an answer? Submit a question and we will get back to you within one business day:</b>
<?php echo $form->create('FaqRequest',array('url'=>array('action'=>'add','controller'=>'faqs'),'onSubmit'=>'return verifyRequiredFields(this);','XXXonSubmit'=>"event.returnValue = false; return false;"));?>
	<?php
		echo $form->input('name',array('class'=>'wide required'));
		echo $form->input('organization',array('class'=>'wide','label'=>'Organization (optional)'));
		?>
		<br/>
		<?
		echo $form->input('faq_topic_id',array('class'=>'wide','label'=>'Topic','empty'=>'None/Other','options'=>$faqTopics));
		echo $form->input('question',array('type'=>'textarea','class'=>'wide'));
		?>
		<br/>
		Please provide a way of contacting you
		<div class="required_one">
		<?
		echo $form->input('email',array('class'=>'wide'));
		echo $form->input('phone',array('class'=>'wide'));
		?>
		</div>
		<br/>
		<?
	?>
	<div align="left">
		<?= $this->Captcha->show(); ?>
		<br/>

		<input id="submit" type="image" src="/images/webButtons2014/grey/large/send.png">
		<script>
		/*
			j('#FaqRequestAddForm').submit(function() {
				j.post("/faq_requests/add", j('#FaqRequestAddForm').serialize(), function(data) {
					j('#faqRequest').html(data);
				});
			});
		*/
			/*
			Event.observe("FaqRequestAddForm", 'submit', function(event) { var verified = verifyRequiredFields('FaqRequestAddForm'); if(verified) { new Ajax.Updater('faqRequest','/faq_requests/add', {asynchronous: true, evalScripts: true, parameters:Form.serialize('FaqRequestAddForm'), requestHeaders:['X-Update', 'faqRequest']}) } }, false); 
			*/
		</script>
	</div>
<?php echo $form->end();?>
</div>
