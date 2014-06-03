<div>
<p>
Ready to checkout? Select a checkout option from below:
</p>

<?= $this->element("account/login", array('anonymous'=>1, 'goto'=>'/checkout/review','checkout'=>1)); ?>

<?= $this->element("cart/cart",array('checkout'=>1,'read_only_summary'=>1)); ?>

</div>
