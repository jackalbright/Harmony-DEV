<div class="bold">
	In order to download templates, please log in or sign up to create an account.
</div>

<br/>

<?= $this->element("account/login"); ?>

<script>
j('#modal').on('submit', 'form', function(e) { // in case signup, failed login attempts, etc we need to keep handler on new objects
	e.preventDefault();
	j(this).ajaxSubmit({target: '#modal'});
	return false;
});
</script>
