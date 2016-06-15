<?php
namespace Craft;

class PrivateMessaging_MessageController extends BaseController
{

	/**
	 * Sends a private message based on the posted params.
	 *
	 * @throws Exception
	 */
	public function actionSaveMessage()
	{
		$this->requirePostRequest();

		$message = new PrivateMessaging_MessageModel();

		$message->subject = craft()->request->getPost('subject');
		$message->body = craft()->request->getPost('body');
		$message->senderId = craft()->request->getPost('senderId');
		$message->recipientId = craft()->request->getPost('recipientId');
		$message->isRead = 0;

		if ($message->validate())
		{
			if (craft()->privateMessaging_messages->saveMessage($message))
			{
				if (craft()->request->isAjaxRequest())
				{
					return $this->returnJson(['success' => true]);
				} else {
					craft()->userSession->setNotice(Craft::t('Message sent.'));
					return $this->redirectToPostedUrl();
				}
			}
			else
			{
				if (craft()->request->isAjaxRequest())
				{
					return $this->returnJson(['success' => false, 'error' => "Couldn't send message"]);
				} else {
					craft()->userSession->setError(Craft::t("Couldn't send message."));
					craft()->urlManager->setRouteVariables(array('message' => $message));
				}
			}
		}

		// Validation failed
		if (craft()->request->isAjaxRequest())
		{
			return $this->returnErrorJson($message->getErrors());
		}
		else
		{
			craft()->userSession->setError('There was a problem with your submission, please check the form and try again!');

			craft()->urlManager->setRouteVariables(array(
				'message' => $message
			));
		}
	}

	public function actionDeleteMessage()
	{
		$this->requirePostRequest();
		$id = craft()->request->getPost('id');

		if (craft()->privateMessaging_messages->deleteMessage($id)) {
			return $this->redirectToPostedUrl();
		}

		return false;
	}
}