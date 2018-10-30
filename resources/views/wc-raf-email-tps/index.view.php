<?php //Email Templates View ?>

<div class="wrap">
	<h2><?php echo self::$menuInstance->title; ?></h2>
	<hr />
	
	<form action="<?php echo admin_url('admin-post.php?action=listen'); ?>" method="POST">
		<input type="hidden" name="controller" value="emailTemplates">
		<input type="hidden" name="rafAction" value="updateTemplate">
		<table class="widefat striped">
			<thead>
				<tr>
					<th><h3>Select Email Template</h3></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>
						<select name="" id="">
							<option value="">Select a template to edit</option>
							<option value="email">Email</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<?php 
							$args = [
								'tinymce' => [
									'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
								]
							];

						wp_editor('test', 'raf-refer-email-template', $args); ?>
					</td>
				</tr>

				<tfoot>
					<tr>
						<td><button type="submit" class="button-primary">Update</button></td>
					</tr>
				</tfoot>
			</tbody>
		</table>
	</form>
</div>