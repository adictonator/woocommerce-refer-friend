<?php
namespace RAF\Controllers\Menus;

use RAF\Helpers\RAFFunctions;

defined('ABSPATH') or die('Not permitted!');

/**
 *
 */
class MenuViewGeneratorController
{
    protected static $menuInstance;

    public static function setView(object $menuInstance)
    {
		self::$menuInstance = $menuInstance;
        self::view(self::$menuInstance->slug);
		$kkk = 'wow';
		$lol = compact('kkk');
        return new self;
    }

    protected static function view($slug)
    {
        if (file_exists(VIEWS_DIR . '/' . $slug . '/index' . VIEW_EXT)) {

            include_once VIEWS_DIR . '/' . $slug . '/index' . VIEW_EXT;
        } else {
            echo "Index file is required";
        }

    }

    public function getAssets(array $menuAssets)
    {
        foreach ($menuAssets as $assetType => $assets) :

            if ($assetType == 'css') :
                $assetPath = VIEWS_URL . '/' . self::$menuInstance->slug . '/assets/' . $assetType;
			elseif ($assetType == 'js'):
				$assetPath = VIEWS_URL . '/' . self::$menuInstance->slug . '/assets/' . $assetType;
			endif;

			$this->resolveAssetsPath($assetPath, $assetType, $assets);
        endforeach;
    }

    public function resolveAssetsPath(string $assetPath, string $assetType, array $assets)
    {
        if (!empty($assets)) :
            foreach ($assets as $asset) :
                $assetPath = "$assetPath/{$asset}";

                $this->loadViewAssets($assetPath, $assetType);

            endforeach;
        endif;
    }

    public function enqueueScript()
    {
        add_action('admin_enquque_scripts', [$this, 'loadViewAssets']);
    }

    public function loadViewAssets(string $assetPath, string $assetType)
    {
        $rand = uniqid();
        if ($assetType == 'css') :
            wp_enqueue_style('yc-' .$rand, $assetPath);
        elseif ($assetType == 'js') :
            wp_enqueue_script('yc-' . $rand, $assetPath, null, false, true);
        endif;
    }
}