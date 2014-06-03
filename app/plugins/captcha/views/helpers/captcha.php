<?
class CaptchaHelper extends Helper
{
	public $helpers = array('Form','Session','Html');


	function show()
	{ # Generated in the image rendering process itself!
		ob_start();
		$img = $this->Html->image("/captcha/captcha/image?t=".urlencode(microtime()),array('class'=>'captcha')); 
		?>
		<div>
			<?= $this->Form->input("captcha_response", array('label'=>"Type the characters shown above",'style'=>'width: 150px;', 'class'=>'required','before'=>$img."<br/>")); ?>
		</div>
		<?
		return ob_get_clean();

	}

	function error()
	{
		return $this->Form->error("captcha_response");
	}


}
