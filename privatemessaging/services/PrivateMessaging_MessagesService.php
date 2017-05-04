<?php
namespace Craft;

/**
 * Private Messaging service
 */
class PrivateMessaging_MessagesService extends BaseApplicationComponent
{

	/**
	 * Save a new message to the database.
	 *
	 * @param  PrivateMessaging_MessageModel $model
	 * @return bool
	 */
	public function saveMessage(PrivateMessaging_MessageModel &$model)
	{
		$record = new PrivateMessaging_MessageRecord();
		$record->setAttributes($model->getAttributes());
		$record->subject = $model->subject;
		$record->body = $model->body;
		return $record->save() ? true : false;
	}

	/**
	 * Get unread messages
	 *
	 * @param string $onlyUnread
	 * @return array
	 */
	public function getMessages($onlyUnread=false) {

		if (!craft()->userSession || !craft()->userSession->getUser()) return [];

		$userId = craft()->userSession->getUser()->id;

		if ($onlyUnread) {
			$records = PrivateMessaging_MessageRecord::model()->findAllByAttributes(['recipientId'=>$userId,'isRead'=>0], ['order' => 'id DESC']);
		} else {
			$records = PrivateMessaging_MessageRecord::model()->findAllByAttributes(['recipientId'=>$userId], ['order' => 'id DESC']);
		}

		return $records;
	}

	/**
	 * Get total message count
	 *
	 * @return int
	 */
	public function getTotalMessageCount() {
		$messages = $this->getMessages();
		return count($messages);
	}

	/**
	 * Get unread message count
	 *
	 * @return int
	 */
	public function getUnreadMessageCount() {
		$messages = $this->getMessages(true);
		return count($messages);
	}

	/**
	 * Get sent messages
	 *
	 * @return array
	 */
	public function getSentMessages() {

		if (!craft()->userSession || !craft()->userSession->getUser()) return [];

		$userId = craft()->userSession->getUser()->id;

		$records = PrivateMessaging_MessageRecord::model()->findAllByAttributes(['senderId' => $userId], ['order' => 'id DESC']);

		return $records;
	}

	/**
	 * Get message from id
	 *
	 * @param int $id
	 * @return object $message
	 */
	public function getMessage($id) {

		$message = PrivateMessaging_MessageRecord::model()->find('id=:id', array(':id'=>$id));

		// mark as read
		if ($message && !$message->isRead) {
			$message->isRead = 1;
			$message->save();
		}

		if ($message && ($message->recipientId == craft()->userSession->getUser()->id)) {
			return $message;
		} else {
			return false;
		}
	}

	/**
	 * Delete message
	 *
	 * @param int $id
	 * @return bool
	 */
	public function deleteMessage($id) {

		$message = PrivateMessaging_MessageRecord::model()->find('id=:id', array(':id'=>$id));

		if ($message && ($message->recipientId == craft()->userSession->getUser()->id)) {
			return $message->delete();
		} else {
			return false;
		}
	}

}
