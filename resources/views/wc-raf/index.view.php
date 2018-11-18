<?php

// Members View 
$controller = self::$menuInstance->controller;
?>

<div class="wrap">
	<h2><?php echo self::$menuInstance->title; ?></h2>
	<hr />

	<table class="widefat striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Email Address</th>
				<th>Total Refered Users</th>
				<th>Available Discounts</th>
			</tr>
		</thead>

		<tbody>
		<?php 
		$allMembers = $controller->getAllMembers();

		if (!empty($allMembers)) :

			foreach ($allMembers as $index => $member) : ?>
			<tr>
				<td><?php echo $index + 1; ?></td>
				<td><?php echo $member->memberEmail; ?></td>
				<td><?php echo count($controller->getTotalRefered($member->memberID)); ?></td>
				<td><?php echo count($controller->getAvailableDiscounts($member->memberID)); ?></td>
			</tr>
			<?php endforeach;
		
		else: ?>
			<tr>
				<td colspan="4">Nothing found.</td>
			</tr>
		<?php endif; ?>

		</tbody>
	</table>
</div>