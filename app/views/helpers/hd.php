<?php 
include_once(dirname(__FILE__)."/../../../includes/encdecclass.php");

class HdHelper extends AppHelper {
	var $encdec = null;

	function scaledimg($src, $attrs = array()) # AT MOST (but ok if under) width specified
	{
		$abspath = APP."/webroot/$src";
		if(!file_exists($abspath) && file_exists(APP."/../$src"))
		{
			$abspath = APP."/../$src";
		}
		list ($defaultwidth,$defaultheight) = getimagesize($abspath);

		if(!empty($attrs['width']) && $defaultwidth < $attrs['width']) # let actual take over...
		{
			$attrs['width'] = $defaultwidth;
		}
		if(!empty($attrs['height']) && $defaultheight < $attrs['height']) # let actual take over...
		{
			$attrs['height'] = $defaultheight;
		}

		?>
			<img src="<?= $src ?>" <? foreach($attrs as $k=>$v) { echo "$k='$v' "; } ?> />
		<?
	}

	function getImageSize($path)
	{
		$abs_path = APP."/webroot/$path";
		list($w,$h) = getimagesize($abs_path);
		return array($w,$h);
	}

	function getShrunkImageSize($path, $max_width, $max_height)
	{
		list($w,$h) = $this->getImageSize($path);
		$w2h = $w/$h;

		$new_width = $max_width;
		$new_height = ceil($new_width/$w2h);
		if ($new_height > $max_height)
		{
			$new_height = $max_height;
			$new_width = ceil($new_height * $w2h);
		}

		return array($new_width, $new_height);
	}

	function decryptCreditCard($encrypted)
	{
		if(!$this->encdec) { $this->encdec = new EncDec(); }
                $cardnum = $this->encdec->phpDecrypt($encrypted);
		return $cardnum;
	}

	function unixToHumanDate($unixdate, $time = false)
	{
		$format = $time ? 'F j, Y H:i:s' : 'F j, Y';
		return date($format, strtotime($unixdate));
		#return date_format(date_create($unixdate), 'F j, Y');
	}

	function mmToIn($mm, $denominator = 8, $html_format = false)
	{
		# Refine
		$in = $mm * 0.0393700787;
		$fraction = $this->getNumericFraction($in, $denominator);
		if ($html_format)
		{
			$fraction = preg_replace("/ (\d+)\/(\d+)/", "<sup>$1</sup>/<sub>$2</sub>", $fraction);
		}
		return $fraction;
	}

	function gm2lb($gm)
	{
		$lb = $gm * 0.00220462262;
		return $lb;
	}

	function gm2oz($gm)
	{
		$lb = $this->gm2lb($gm);
		$oz = $lb*16;
		return $oz;
	}

	function getNumericFraction($num, $denominator = 8)
	{
		$whole_num = intval($num);
		$remain_num = $num - $whole_num;
		$numerator = intval($remain_num * $denominator);
		if ($numerator > 0)
		{
			$largest_common_integer = $this->getLargestCommonInteger($numerator, $denominator);
			if ($whole_num > 0)
			{
				return sprintf("%u %u/%u", $whole_num, $numerator/$largest_common_integer, $denominator/$largest_common_integer);
			} else {
				return sprintf(" %u/%u", $numerator/$largest_common_integer, $denominator/$largest_common_integer);
			}
		} else {
			return sprintf("%u", $whole_num);
		}
	}

	function getLargestCommonInteger($numerator, $denominator)
	{
		$int = 1;
		for($i = $int; $i <= $numerator; $i++)
		{
			if (
				$numerator % $i == 0 &&
				$denominator % $i == 0
			)
			{
				$int = $i;
			}
		}

		return $int;
	}

	function pluralize($string, $ucwords = false)
	{
		$string = preg_replace("/^\s*(.*)\s*$/", '$1', $string);
		$inflect = new Inflector();
		$plural = $inflect->pluralize($string);
		return $ucwords ? ucwords($plural) : $plural;
	}

	function product_element($element, $prod, $args = array(), $optional = false)
	{
		$view =& ClassRegistry::getObject('view');

		$content = $view->element("{$element}_".$prod, $args);
		if (!$content || preg_match("/^Not Found:/", $content))
		{
			$content = $view->element($element, $args);
		}

		if ($optional && (!$content || preg_match("/^Not Found:/", $content)))
		{
			return null;
		}
		return $content;
	}
}
?>
