<?php
	$aspellConf = getenv("ASPELL_CONF");
	putenv ("ASPELL_CONF=ignore-case true");
	function spellCheckArray($terms) {
		$dictionary = pspell_new("en");
		$allCorrect = true;
		foreach ($terms as $term) {
			if (is_array($term)) {
				$termCorrect = spellCheckArray($term);				
			} else {
				$termCorrect = pspell_check ($dictionary, $term);
			}
			$allCorrect = ($allCorrect && $termCorrect);
		}
		return $allCorrect;
	}
	
	function spellCorrectArray($terms) {
		$dictionary = pspell_new("en");
		$result = array();
		foreach ($terms as $term) {
			if (is_array($term)) {
				$result[] = spellCorrectArray($term);				
			} else {
				$termCorrect = pspell_check ($dictionary, $term);
				if (!$termCorrect) {
					$suggestions = pspell_suggest($dictionary, $term);
					$result[] = $suggestions[0];
				} else {
					$result[] = $term;
				}
			}
		}
		return $result;
	}
?>
