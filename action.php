<?php
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_googletagmanager extends DokuWiki_Action_Plugin {

    const GTMID = 'GTMID';

    /**
	 * return some info
	 */
	function getInfo(){
		return array(
			'author' => 'Alexander Lehmann',
			'email'  => 'alexlehm@gmail.com',
			'date'   => '2014-02-01',
			'name'   => 'Google Tag Manager Plugin',
			'desc'   => 'Plugin to embed Google Tag Manager in your wiki.',
			'url'    => 'http://www.lehmann.cx/wiki/projects:dokuwiki_gtm',
		);
	}

	/**
	 * Register its handlers with the DokuWiki's event controller
	 */
	function register(Doku_Event_Handler $controller) {
	    $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE',  $this, '_addHeaders');
	}

	function _addHeaders (&$event, $param) {

		if(!$this->getConf(self::GTMID)) return;
		$event->data['noscript'][] = array (
		  '_data' => '<iframe src="//www.googletagmanager.com/ns.html?id='.$this->getConf(self::GTMID).'" height="0" width="0" style="display:none;visibility:hidden"></iframe>',
		);
		$event->data['script'][] = array (
		  'type' => 'text/javascript',
		  '_data' => "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','".$this->getConf(self::GTMID)."');",
		);
	}
}
?>
