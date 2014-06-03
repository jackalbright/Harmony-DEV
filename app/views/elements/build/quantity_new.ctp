<div id="quantity_container">

<?
$discounted = ($build['retail_price_list']['total'] > $build['quantity_price_list']['total']);

?>
<div>

<?= $this->element("build/estimate"); ?>
<br/>

<div align="right">
<? if(empty($build['cart_item_id'])) { ?>
<input type="image" align="middle" alt="Add to Cart" src="/images/webButtons2014/orange/large/addToCart.png" onClick="document.forms.build_form.submit();"/>
<!--<input type="image" align="middle" alt="Add to Cart" src="/images/webButtons2014/orange/large/addToCart.png" onClick="return assertMinimum('<?= $build['Product']['minimum'] ?>');"/>-->
<!--<input type="submit" name="submit" value="Add To Cart"  onClick="return assertMinimum('<?= $build['Product']['minimum'] ?>');"/>-->
<!--<input type="submit" name="submit" value="Add To Cart"  />-->
<? } else { ?>

	<!--<input type="image" align="middle" alt="Update Cart" src="/images/webButtons2014/orange/large/updateCart.png" onClick="return assertMinimum('<?= $build['Product']['minimum'] ?>');"/>-->
    <input type="image" align="middle" alt="Update Cart" src="/images/webButtons2014/orange/large/updateCart.png" onClick="alert("add to cart")"/>
   <!-- <input type="submit" name="submit" value="Update Cart"   onClick="return assertMinimum('<?= $build['Product']['minimum'] ?>');"/>-->
<? } ?>

<br/>
<br/>
<a href="/build/save"><img src="/images/buttons/small/Save-For-Later-grey.gif"/></a>
</div>

</div>

</div>

</div>
