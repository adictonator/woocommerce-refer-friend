<?php get_header(); ?>

<div class="raf-wrapper">
	<h2><?php echo HelperPlug::PLUGIN_LONG_NAME; ?> Portal</h2>
	<hr />

	<form id="raf-refer-product-form">
		<input type="hidden" name="controller" value="templates">
		<input type="hidden" name="rafAction" value="referProduct">
		<ul>
		<?php
		$rafSettingsData = get_option('rafSettingsData');
		$products = $rafSettingsData->products;

		foreach ($products as $product) :
			$getProduct = wc_get_product($product);
			$productData = $getProduct->get_data(); 
			?>
		
			<li>
				<?php echo $productData['name']; ?>
				<button data-raf-prod-id="<?php echo $productData['id']; ?>">Refer</button>
				<!-- Cliucking on refer will trigger an AJAX wchi will insert the logged in user data to raf table and create
				a aff link for them and then display it,
				
				next time it won't do it since aff id is already generated -->
			</li>
		
		<?php endforeach; ?>
		</ul>
	</form>
</div>

<div class="raf-popup" data-raf-popup="user-auth">

</div>

<div class="raf-popup" data-raf-popup="refer-prod" style="display: none">
<form action="">
	<input type="hidden" name="controller" value="refer">
	<input type="hidden" name="rafAction" value="processRefer">
	<input type="text" name="rafReferName" placeholder="Your Friend's Name">
	<input type="text" name="rafReferEmail" placeholder="Your Friend's Email">
	<textarea name="rafReferMessage" rows="5" placeholder="Add a personal message for your friend!"></textarea>
	<button data-raf-refer-send>Send</button>
</form>
</div>

<?php get_footer(); ?>