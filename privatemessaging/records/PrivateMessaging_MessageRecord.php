<?php
namespace Craft;

class PrivateMessaging_MessageRecord extends BaseRecord
{
	public function getTableName()
	{
		return 'privatemessaging_messages';
	}

	protected function defineAttributes()
	{
		return array(
			'subject' => AttributeType::String,
			'body' => AttributeType::Mixed,
			'senderId' => AttributeType::Number,
			'recipientId' => AttributeType::Number,
			'isRead' => AttributeType::Bool,
		);
	}

	public function defineRelations()
	{
		return array(
			'sender' => array(static::BELONGS_TO, 'UserRecord', 'senderId'),
			'recipient' => array(static::BELONGS_TO, 'UserRecord', 'recipientId'),
		);
	}
}