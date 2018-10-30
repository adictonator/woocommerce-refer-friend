<?php

defined('ABSPATH') or die('Not permitted!');

/**
 * Helper class for RAF.
 * Might be deprecated. Might even expand.
 */

 /** Global variable to hold current user. */

abstract class HelperPlug {
	const PLUGIN_LONG_NAME = 'Refer a Friend';
	const PLUGIN_SHORT_NAME = 'RAF';
	const PLUGIN_SLUG = 'wc-raf';
	const PLUGIN_PAGE_TITLE = self::PLUGIN_LONG_NAME . ' &bull; ';

	/**
	 * Not sure if it should be here at all.
	 * 
	 */
	public static function getPostData($postType = 'post') {
		$allPages = new WP_Query([
			'post_type' => $postType,
			'post_status' => 'publish'
		]);

		if ($allPages->have_posts()) :
			
			while ($allPages->have_posts()) : $allPages->the_post();
				$pages[get_the_ID()] = get_the_title();
			endwhile;

			wp_reset_postdata();
		endif;

		return $pages;
	}

	public static function initSession()
	{
		if (!session_id()) :
			session_start();

			if (!isset($_SESSION['raf'])) :
				$_SESSION['raf'] = (object) [];
			endif;
		endif;
	}
}