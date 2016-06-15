<?php
namespace Craft;

class PrivateMessaging_MessageModel extends BaseModel
{
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
}
