<?php

namespace RAF\Helpers;

defined('ABSPATH') or die('Not permitted!');

abstract class RAFFunctions
{
	public static function getPostData($postType = 'post')
	{
		$allPages = new \WP_Query([
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