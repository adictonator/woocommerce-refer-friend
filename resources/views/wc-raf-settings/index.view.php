<?php

defined('ABSPATH') or die('Not permitted!');
// Main Index View ?>

<div class="wrap <?php echo HelperPlug::PLUGIN_SLUG; ?>">
	<h2><?php echo self::$menuInstance->title; ?></h2>
	<hr />

	<form action="<?php echo admin_url('admin-post.php?action=listen'); ?>" method="POST">
		<input type="hidden" name="controller" value="settings">
		<input type="hidden" name="rafAction" value="setPages">
		<table class="widefat striped">
			<tbody>
				<tr>
					<td>
						<table class="widefat striped">
							<thead>
								<tr>
									<th><h3>General Settings</h3></th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td><label for="raf_template_id">Select Page for Refer a Friend</label></td>
									<td>
										<select name="rafTemplateIDs[default]" id="raf_template_id">
											<option value="">Select a page</option>

											<?php foreach (HelperPlug::getPostData('page') as $ID => $pageTitle) : ?>
												<option value="<?php echo $ID; ?>"><?php echo $pageTitle; ?></option>
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
										<select name="rafProducts[]" id="raf_products" multiple>
											<option value="">Select a product</option>

											<?php foreach (HelperPlug::getPostData('product') as $ID => $productTitle) : ?>
												<option value="<?php echo $ID; ?>"><?php echo $productTitle; ?></option>
											<?php endforeach; ?>
										</select>
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