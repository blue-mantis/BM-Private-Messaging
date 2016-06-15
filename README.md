# BM Private Messaging
A Craft CMS plugin. Grant your site users the power of communication, via private messaging!

![screenshot](http://i.imgur.com/QPGKwOi.png)

# User Guide

##1. Send a private message

Add the following form to your template:

```twig
<form method="post" action="" accept-charset="UTF-8" id="privateMessagingSendForm">

    <input type="hidden" name="action" value="privateMessaging/message/saveMessage">
    <input type="hidden" name="redirect" value="/message-sent">
    <input type="hidden" name="senderId" value="{{ currentUser.id }}">
    <input type="hidden" name="recipientId" value="{{ recipientId }}">

    <label for="privateMessagingSubject">Subject</label>
    <input type="text" id="privateMessagingSubject" name="subject" value="">

    <label for="privateMessagingMessage">Message</label>
    <textarea id="privateMessagingMessage" name="body" form="privateMessagingSendForm" required></textarea>

    <input type="submit" value="Submit">
</form>
```

You will need to set the following form values:

 * **redirect** - This should be set to the template to redirect to, upon successfully sending the private message
 * **senderId** - This should be the ID of the user sending the message
 * **recipientId** - This should be the ID of the user due to receive the message

##2. View messages

To view the logged in users messages, you will need to add the following to your template:

```twig
{% for message in privateMessages %}

{% endfor %}
```

Within this loop you can access the following private message attributes:

* **message.id** - The message ID. [**type**: *integer*]
* **message.subject** - The subject of the message. [**type**: *string(255)*]
* **message.body** - The body of the message. [**type**: *text*]
* **message.sender** - The sender user. [**type**: *user object*]
* **message.recipient** - The recipient user. [**type**: *user object*]
* **message.isRead** - Whether the message has been read. [**type**: *boolean*]
* **message.dateCreated** - The created dateTime of the message. [**type**: *dateTime*]

##3. View unread message count

To view the unread message count for the currently logged in user, you will need to add the following to your template:

```twig
{{ unreadPrivateMessageCount }}
```

##4. View total message count

To view the total message count for the currently logged in user, you will need to add the following to your template:

```twig
{{ totalPrivateMessageCount }}
```

##5. View a message

To access an individual message, you will need to pass the id of a message to your template.

This can be achieved by setting up a new route that passes the message id (number) to your template, like so:

[!screenshot](http://i.imgur.com/ap8YAMJ.png)

Inside the template, we will use this ID (number) to retrieve the message, but, first we check to ensure we have actually been passed an ID:

```twig
{% if number is not defined %}
    {% exit 404 %}
{% else %}
```

If we have an ID, then we pass this to the getPrivateMessage method (which is a twig extension built into the plugin):

```twig
{% set message = number|getPrivateMessage %}}
```

If this method does not return an associated message, it will return false. We may wish to handle that also:

```twig
{% if message == false %}
    {% exit 404 %}
{% endif %}
```

**The getPrivateMessage method with return a false value when:**

1. **Out of range** - *A message with that ID doesn't exist in the database*
2. **Deleted** - *A message with that ID has been deleted from the database*
3. **Permissions** - *A message with that ID does not belong to the user trying to access it*

##6. Delete a message

Add the following form to your template:

```twig
<form method="post" action="" accept-charset="UTF-8" id="privateMessagingDeleteForm">
    <input type="hidden" name="action" value="privateMessaging/message/deleteMessage">
    <input type="hidden" name="redirect" value="/messages">
    <input type="hidden" name="id" value="{{ message.id }}">
    <input type="submit" value="Delete">
</form>
```

**You will need to set the following form values:**

* **redirect** - This should be set to the template to redirect to, upon successfully deleting the private message
* **id** - This should be the ID of the message

NB: A user can only delete messages that belong to them.

# More plugins by Blue Mantis

... can be found [here](http://plugins.bluemantis.com/)
