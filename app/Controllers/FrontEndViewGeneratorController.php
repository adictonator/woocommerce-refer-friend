<?php
namespace RAF\Controllers;

defined('ABSPATH') or die('Not permitted!');

class FrontEndViewGeneratorController
{
	private static $templateDirectory;
	
	public static function setView(string $templateDirectory, string $templateName)
	{
		self::$templateDirectory = $templateDirectory;

		self::loadTemplateAssets()->enqueueScript();

		return TEMPLATES_DIR . "/{$templateDirectory}/{$templateName}" . VIEW_EXT;
	}

    public function enqueueScript()
    {
        add_action('wp_enquque_scripts', [$this, 'loadTemplateAssets']);
        add_action('wp_head', [$this, 'wpAJAXAddress']);
    }

    public static function loadTemplateAssets()
    {
		if (file_exists(TEMPLATES_DIR . '/' . self::$templateDirectory . '/assets/css/app.css')) {
			$assetPath = TEMPLATES_URL . '/' . self::$templateDirectory . '/assets/css/app.css'; 
			wp_enqueue_style('raf-styles', $assetPath);
		}

		if (file_exists(TEMPLATES_DIR . '/' . self::$templateDirectory . '/assets/js/app.js')) {
			$assetPath = TEMPLATES_URL . '/' . self::$templateDirectory . '/assets/js/app.js'; 
			wp_enqueue_script('raf-scripts', $assetPath, null, false, true);
		}
		
		return new FrontEndViewGeneratorController;
	}
	
	public function wpAJAXAddress()
	{ ?>
		<script>
			const adminAJAX = "<?php echo admin_url('admin-ajax.php'); ?>";
		</script>
	<?php }
}
