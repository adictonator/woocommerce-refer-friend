<?php

use RAF\Models\RAFSettingsModel;

defined('ABSPATH') or die('Not permitted!');

$selectedPages = RAFSettingsModel::getTemplatesData();
$selectedProducts = RAFSettingsModel::getProductsData();
$discounts = RAFSettingsModel::getDiscountsData();

?>

<div class="wrap">
	<h2><?php echo self::$menuInstance->title; ?></h2>
	<hr />

	<?php if (isset($_SESSION['raf']->adminFlash)) : ?>
		<div class="notice notice-<?php echo $_SESSION['raf']->adminFlash->type; ?> is-dismissible">
			<p><?php echo $_SESSION['raf']->adminFlash->msg; ?></p>
		</div>
	<?php 
		unset($_SESSION['raf']->adminFlash);
	endif; ?>

	<form action="<?php echo admin_url('admin-post.php?action=listen'); ?>" method="POST">
		<input type="hidden" name="controller" value="settings">
		<input type="hidden" name="rafAction" value="updateSettingsData">
		<table class="widefat striped wc-raf-table">
			<tbody>
				<tr>
					<td>
						<table class="widefat striped wc-raf-table__inner">
							<thead>
								<tr>
									<th colspan="2"><h3>Template Pages</h3></th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<th><label for="raf_template_id">Select Page for Refer a Friend</label></th>
									<td>
										<select name="rafTemplateIDs[default]" id="raf_template_id" class="wp-raf-input ">
											<option value="">Select a page</option>

											<?php foreach (HelperPlug::getPostData('page') as $ID => $pageTitle) : ?>
												<option value="<?php echo $ID; ?>" <?php echo array_key_exists($ID, $selectedPages) ? 'selected' : ''; ?>><?php echo $pageTitle; ?></option>
											<?php endforeach; ?>

										</select>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table class="widefat striped">
							<thead>
								<tr>
									<th><h3>Select Products to Refer</h3></th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>
										<select name="rafProducts[]" id="raf_products" class="wp-raf-input" multiple>
											<option value="">Select a product</option>

											<?php foreach (HelperPlug::getPostData('product') as $ID => $productTitle) : ?>
												<option value="<?php echo $ID; ?>" <?php echo in_array($ID, $selectedProducts) ? 'selected' : ''; ?>><?php echo $productTitle; ?></option>
											<?php endforeach; ?>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table class="widefat striped wc-raf-table__inner">
							<thead>
								<tr>
									<th colspan="2"><h3>Discounts</h3></th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<th><label for="">Add Discount Type</label></th>
									<td>
										<ul data-raf-disc-wrap>
											<?php if (!empty($discounts)) :
												$count = 0;										
												foreach ($discounts as $totalReferal => $discountAmount) : ?> 

												<li <?php echo $count == 0 ? 'data-raf-disc-init' : ''; ?>>
													<div>
														<span>Set free product</span>
														<input type="checkbox" data-raf-disc-switch name="hasFreeProd[]" <?php echo isset($discountAmount['freeProd-' . $ID]) ? 'checked' : ''; ?>>
													</div>
													<div>
														<span>Total Referal</span><input type="number" name="totalReferal[]" palceholder="eg: 5" class="wp-raf-input--small" min="0" value="<?php echo $totalReferal; ?>">
													</div>

													<div data-raf-amount-disc style="display: <?php echo isset($discountAmount['discount']) ? 'block' : 'none'; ?>">
														<span>Discount Amount</span><input type="number" name="discountAmount[]" 	placeholder="eg: 10" class="wp-raf-input--small" min="0" value="<?php echo $discountAmount['discount']; ?>">
													</div>
													<div data-raf-prod-disc style="display: <?php echo !isset($discountAmount['discount']) ? 'block' : 'none'; ?>">
														<span>Select a product</span>

														<select name="freeProd[]">
															<option value="">Select a product</option>

															<?php foreach (HelperPlug::getPostData('product') as $ID => $productTitle) : ?>
																<option value="<?php echo $ID; ?>" <?php echo isset($discountAmount['freeProd-' . $ID]) ? 'selected' : ''; ?>><?php echo $productTitle; ?></option>
															<?php endforeach; ?>
														</select>
													</div>
													<?php if ($count == 0) : ?>
													<button data-raf-disc="add" type="button" class="button-primary">Add +</button>
													<?php else : ?>
													<button data-raf-disc="remove" type="button" class="button-secondary">Remove -</button>
													<?php endif; ?>
												</li>

												<?php 
												$count++;	
											endforeach;

											else : ?>
											
											<li data-raf-disc-init>
												<div>
													<span>Set free product</span>
													<input type="checkbox" data-raf-disc-switch name="hasFreeProd[]" value="no">
												</div>
												<div>
													<span>Total Referal</span><input type="number" name="totalReferal[]" palceholder="eg: 5" class="wp-raf-input--small" min="0">
												</div>
												<div data-raf-amount-disc>
													<span>Discount Amount</span><input type="number" name="discountAmount[]" placeholder="eg: 10" class="wp-raf-input--small" min="0">
												</div>
												<div data-raf-prod-disc style="display: none">
													<span>Select a product</span>

													<select name="freeProd[]">
														<option value="">Select a product</option>

														<?php foreach (HelperPlug::getPostData('product') as $ID => $productTitle) : ?>
															<option value="<?php echo $ID; ?>"><?php echo $productTitle; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
												<button data-raf-disc="add" type="button" class="button-primary">Add +</button>
											</li>
										
											<?php endif; ?>
										
										</ul>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>

			<tfoot>
				<tr>
				<td><button type="submit" class="button-primary">Save Settings</button></td>
				</tr>
			</tfoot>
			
		</table>
	</form>
</div>