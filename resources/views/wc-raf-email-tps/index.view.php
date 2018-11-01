<?php //Email Templates View 

use RAF\Models\RAFEmailTemplatesModel;

defined('ABSPATH') or die('Not permitted!');

RAFEmailTemplatesModel::init();
$subject = RAFEmailTemplatesModel::getSubject('email');
$content = RAFEmailTemplatesModel::getContent('email');
?>

<div class="wrap">
	<h2><?php echo self::$menuInstance->title; ?></h2>
	
	<?php if (isset($_SESSION['raf']->adminFlash)) : ?>
	<div class="notice notice-<?php echo $_SESSION['raf']->adminFlash->type; ?> is-dismissible">
			<p><?php echo $_SESSION['raf']->adminFlash->msg; ?></p>
		</div>
		<?php 
		unset($_SESSION['raf']->adminFlash);
	endif; ?>
	<hr />
	
	<form action="<?php echo admin_url('admin-post.php?action=listen'); ?>" method="POST">
		<input type="hidden" name="controller" value="emailTemplates">
		<input type="hidden" name="rafAction" value="processTemplateData">
		<table class="widefat striped">
			<thead>
				<tr>
					<th><h3>Select Email Template</h3></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>
						<select name="emailTemplateID" id="emailTemplateID">
							<option value="">Select a template to edit</option>
							<option value="email" selected>Email</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><input type="text" name="subject" placeholder="Email Subject" value="<?php echo $subject; ?>"></td>
				</tr>
				<tr>
					<td>
						<?php 
							$args = [
								'tinymce' => [
									'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
								]
							];

						wp_editor(stripcslashes(html_entity_decode($content)), 'content', $args); ?>
					</td>
				</tr>
				<tr>
					<th><strong>Available Tags:</strong> <em>%customer_email%</em>, <em>%refer_link%</em></th>
				</tr>
			</tbody>

			<tfoot>
				<tr>
					<td><button type="submit" class="button-primary">Update</button></td>
				</tr>
			</tfoot>
		</table>
	</form>
</div>