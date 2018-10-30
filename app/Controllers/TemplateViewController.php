<?php
namespace RAF\Controllers;

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
		$this->getTemplatePage();
		add_filter('page_template', [$this, 'setTemplatePage']);	
	}

	public function getTemplatePage()
	{
		$templatePageData = get_option('rafSettingsData');
		$templatePageIDs = $templatePageData->templatePageIDs;

		$this->pageIDs = $templatePageIDs;
	}

	public function setTemplatePage($template)
	{
		global $post;

		if (property_exists($this->pageIDs, $post->ID)) {
			$templateData = $this->pageIDs->{$post->ID};

			$this->templateName = isset($templateData->name) ? $templateData->name : $this->templatename;
			$this->templateDirectory = isset($templateData->directory) ? $templateData->directory : $this->templateDirectory;

			$template = FrontEndViewGeneratorController::setView($this->templateDirectory, $this->templateName);
		}

		return $template;
	}
}
