<?php
namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class PrivateMessagingTwigExtension extends \Twig_Extension
{

	public function getFilters() {
		return array(
			'getPrivateMessage' => new Twig_Filter_Method($this,'getPrivateMessage'),
		);
	}

	/**
	 * Returns an array of global variables.
	 *
	 * @return array An array of global variables.
	 */
	public function getGlobals()
	{
		$globals['totalPrivateMessageCount'] = craft()->privateMessaging_messages->getTotalMessageCount();
		$globals['unreadPrivateMessageCount'] = craft()->privateMessaging_messages->getUnreadMessageCount();
		$globals['privateMessages'] = craft()->privateMessaging_messages->getMessages();
		return $globals;
	}

	public function getName()
	{
		return Craft::t('BM Private Messaging');
	}

	/**
	 * Get message from id
	 *
	 * @param int $id
	 * @return object $message
	 */
	public function getPrivateMessage($id) {
		$message = craft()->privateMessaging_messages->getMessage($id);
		return $message;
	}

}
