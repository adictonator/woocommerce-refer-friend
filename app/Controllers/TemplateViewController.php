<?php
namespace RAF\Controllers;

use RAF\Models\RAFSettingsModel;

defined('ABSPATH') or die('Not permitted!');

/**
 * NEED REWORKING -- every function
 */
class TemplateViewController
{
	private $pageIDs;
	private $templateName = 'default';
	private $templateDirectory = 'default';

	public function __construct()
	{
		$this->pageIDs = RAFSettingsModel::init()->getTemplatesData();	

		add_filter('page_template', [$this, 'setTemplatePage']);	
		add_filter('display_post_states', [$this, 'setTemplatePageState'], 10, 2);	
	}

	public function setTemplatePage($template)
	{
		global $post;

		if (array_key_exists($post->ID, $this->pageIDs)) {
			$templateData = $this->pageIDs[$post->ID];

			$this->templateName = isset($templateData['name']) ? $templateData['name'] : $this->templatename;
			$this->templateDirectory = isset($templateData['directory']) ? $templateData['directory'] : $this->templateDirectory;

			$template = FrontEndViewGeneratorController::setView($this->templateDirectory, $this->templateName);
		}

		return $template;
	}

	public function setTemplatePageState($postState, $post)
	{
		if (array_key_exists($post->ID, $this->pageIDs)) :
			$postState['wc_page_for_raf'] = __('Refer a Friend Page');
		endif;

		return $postState;
	}
}
