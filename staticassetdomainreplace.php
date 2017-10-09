<?php
// no direct access
defined( '_JEXEC' ) or die;

class plgSystemStaticAssetDomainReplace extends JPlugin
{
	protected $domaininsert = "";

	// automatically get application instance
	protected $app;

	/**
	 * Plugin method with the same name as the event will be called automatically.
	 */
	public function onAfterRender()
	{
		/*
		 * Plugin code goes here.
		 * You can access database and application objects and parameters via $this->db,
		 * $this->app and $this->params respectively
		 */

		$this->app->enqueueMessage('AfterRender!', 'error');
		$html = $this->app->getBody();
		$html = $html . '<!-- lol changed -->';

		if ($this->app->isClient('site')) {
			$domaininsert = $this->params->get('domain_scheme') . $this->params->get('insert_domain');

			$html = $this->replaceEnabled($html, $this->params);

			if (empty($html)) {
				// error some stuff
				$this->app->enqueueMessage(JText::_('SADM ERROR!'), 'error');
			} else {
			}
		}
		else {
			$this->app->enqueueMessage('SADM: NOT SITE!', 'error');
		}
		$this->app->setBody($html);
	}

	/*
	 * Call the enabled replace functions, according to which are enabled
	 * via the plugin settings.
	 */
	protected static function replaceEnabled($html, $plg_params) {

		// <link> tags
		if ($plg_params->get('enable_tag_link')) {

		}

		// <img> tags
		if ($plg_params->get('enable_tag_img')) {

		}

		// <script> tags
		/*
		 * Regex: ((?:<script[^>]+(?:src)\s*=\s*)(?!['"]?(?:data|http|\/\/))['"]?)(([^'"\)\s>]+\/([^'"\)\s>\.]+\.(pack\.js|min\.js|js|jpg|png|gif|bmp|ico)))\??[^'"\)\s>]*)
		 * use: $1<insert>$2
		 * source: $2
		 * no querystring: $3
		 * filename without path: $4
		 * file extension: $5
		 */
		if ($plg_params->get('enable_tag_script')) {
			$pattern = '/((?:<script[^>]+(?:src)\s*=\s*)(?![\'"]?(?:data|http|\/\/))[\'"]?)(([^\'"\)\s>]+\/([^\'"\)\s>\.]+\.(pack\.js|min\.js|js|jpg|png|gif|bmp|ico)))\??[^\'"\)\s>]*)/';
			$replacement = '$1' . $domaininsert . '$2';

			$html = preg_replace($pattern, $replacement, $html);
		}

		// url()s in <style> tags
		if ($plg_params->get('enable_tag_style_url')) {

		}

		return $html;
	}
}
?>
