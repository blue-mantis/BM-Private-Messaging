<?php
namespace Craft;

class PrivateMessagingPlugin extends BasePlugin
{

	function getName()
	{
		return Craft::t('BM Private Messaging');
	}

	function getVersion()
	{
		return '1.3.0';
	}

	function getDeveloper()
	{
		return 'Blue Mantis';
	}

	function getDeveloperUrl()
	{
		return 'http://bluemantis.com';
	}

	/**
	 * @return string
	 */
	public function getDocumentationUrl()
	{
		return 'https://github.com/blue-mantis/BM-Time-Ago-In-Words';
	}

	function hasCpSection()
	{
		return false;
	}

	/**
	 * Registers the Twig extension.
	 *
	 * @return PrivateMessagingTwigExtension
	 */
	public function addTwigExtension()
	{
		Craft::import('plugins.privatemessaging.twigextensions.PrivateMessagingTwigExtension');
		return new PrivateMessagingTwigExtension();
	}

}
