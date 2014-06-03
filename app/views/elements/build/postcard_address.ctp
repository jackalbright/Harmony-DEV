<div class="clear">
		<!--<h2><?php echo $counter;?>. Add address/company source for the  postcard <span class="note">(Optional)</span></h2>-->
<!--						<p class="note">
			Example: &#8220;Happy Birthday, John &#8212; Your friend, Mary.&#8221;  
		</p>  -->
		<div id="addressField">
			<p>
				<textarea id="postcardAddressInput" name="data[options][postcardAddressInput]" rows="3" cols="26" onChange="completeBuildStep('<?=$i?>');" onkeyup="typingAddress(event);"><?php echo $currentItem->parts->postcardAddress; ?></textarea>
				<br />
				<span class="note">
					Maximum length: <?php echo $this_product->address_length; ?> characters.
					<br />
					Current Length: <span id="addressLength">0</span> characters.
				</span>
			</p>
		</div>
</div>

