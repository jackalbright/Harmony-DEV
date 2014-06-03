<div class="clear">
		<!--<h2><?php echo $counter;?>. Add personalization <span class="note">(Optional - Free)</span></h2>-->
		<p class="note">
			<!--Example: &#8220;Happy Birthday, John &#8212; Your friend, Mary.&#8221;-->
			Example: <span style="font-weight: bold; font-variant: small-caps;">Springfield History Museum</span>
		</p>
		<div id="personalizationField">
			<p>
				<textarea id="personalizationInput" name="personalizationInput" rows="2" cols="26" onkeyup="typingPersonalization(event);"><?php echo (!empty($currentItem->parts->personalizationInput)  ? $currentItem->parts->personalizationInput : $currentItem->parts->personalization);  ?></textarea>
				<br />
				<span class="note">
					Maximum length: <?php echo $this_product->personalizationLimit; ?> characters.
					<br />
					Current Length: <span id="personalizationLength">0</span> characters.
				</span>
			</p>
		</div>
		<p>
			Personalization typography
			<br />
			<input type="radio" id="personalizationStyleScript" name="personalizationStyle" value="script" <?php $default = true; if ( ! isset($currentItem->parts->personalizationStyle) || ($currentItem->parts->personalizationStyle == 'script') ) {echo 'checked="checked"'; $default = false;} ?> /><img src="/new-images/script-font.gif" alt="script font" width="96" height="25" align="middle" />
			&nbsp;&nbsp;
			<input type="radio" id="personalizationStyleBlock" name="personalizationStyle" value="block" <?php if ($default) echo 'checked="checked"'; ?> /><img src="/new-images/block-font.gif" alt="block font" width="96" height="25" align="middle" />
			<br />
			<span class="note">Personalization text will be centered</span>
		</p>
</div>

