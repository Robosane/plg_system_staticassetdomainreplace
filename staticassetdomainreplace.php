<?php
// no direct access
defined( '_JEXEC' ) or die;

class plgSystemStaticAssetDomainReplace extends JPlugin
{
	protected $domaininsert = "";
	protected $r_filetypes;

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

		if ($this->app->isClient('site')) {
			$html = $this->app->getBody();
			$this->domaininsert = $this->params->get('domain_scheme') . $this->params->get('insert_domain');

			$this->r_filetypes =
				str_replace(',', '|', // replace the commas with the regex OR|
				preg_quote( // puts the \escape for min\.js etc.
				preg_replace('/\s+/', '', // strip all whitespace
					$this->params->get('filetypes')
				)));

			$html_new = $this->replaceEnabled($html, $this->params);

			if (empty($html_new)) {
				// error some stuff?
				// $this->app->enqueueMessage(JText::_('SADM ERROR!'), 'error');
			} else { // then it probably worked
				$html = $html_new;
				// done, apply changes.
				$this->app->setBody($html);
			}

		}
		else { // then we're not at the frontend
			// don't do anything...
		}
	}

	/*
	 * Call the enabled replace functions, according to which are enabled
	 * via the plugin settings.
	 */
	protected function replaceEnabled($html, $plg_params) {

		// <link> tags
		if ($plg_params->get('enable_tag_link')) {

		}

		// <img> tags
		if ($plg_params->get('enable_tag_img')) {

		}

		// <script> tags
		/*
		 * Regex: ((?:<script[^>]+(?:src)\s*=\s*)(?!['"]?(?:data|http|\/\/))['"]?)((\/[^'"\)\s>]+\/([^'"\)\s>\.]+\.(pack\.js|min\.js|js|jpg|png|gif|bmp|ico)))[^[:alnum:]]\??[^'"\)\s>]*)
		 * use: $1<insert>$2
		 * source: $2
		 * no querystring: $3
		 * filename without path: $4
		 * file extension: $5
		 */
		if ($plg_params->get('enable_tag_script')) {
			$pattern = '/((?:<script[^>]+(?:src)\s*=\s*)(?![\'"]?(?:data|http|\/\/))[\'"]?)((\/[^\'"\)\s>]+\/([^\'"\)\s>\.]+\.(' . $this->r_filetypes . ')))[^[:alnum:]]\??[^\'"\)\s>]*)/';
			$replacement = '${1}' . $this->domaininsert . '${2}';

			$html = preg_replace($pattern, $replacement, $html);
		}

		// url()s in <style> tags
		/*
		 * Regex: ((?:url\()(?!['"]?(?:data|http))['"]?)(([^'"\)\s>]+\/([^'"\)\s>]+\.(?:js|jpg|png|gif|bmp|ico)))[^[:alnum:]]+?\??[^'"\)\s>]*)
		 * use: $1<insert>$2
		 * source: $2
		 * no querystring: $3
		 * filename without path: $4
		 * file extension: $5
		 */
		if ($plg_params->get('enable_tag_style_url')) {
			$pattern = '/((?:url\()(?![\'"]?(?:data|http))[\'"]?)(([^\'"\)\s>]+\/([^\'"\)\s>]+\.(?:' . $this->r_filetypes . ')))[^[:alnum:]]+?\??[^\'"\)\s>]*)/';
			$replacement = '${1}' . $this->domaininsert . '${2}';

			$html = preg_replace($pattern, $replacement, $html);
		}

		return $html;
	}
}
?>
