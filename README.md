[![Build Status](https://travis-ci.org/thecodingmachine/swift-twig-mail-template.svg?branch=5.0)](https://travis-ci.org/thecodingmachine/swift-twig-mail-template)
[![Coverage Status](https://coveralls.io/repos/thecodingmachine/swift-twig-mail-template/badge.svg?branch=5.0&service=github)](https://coveralls.io/github/thecodingmachine/swift-twig-mail-template?branch=5.0)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/thecodingmachine/swift-twig-mail-template/badges/quality-score.png?b=5.0)](https://scrutinizer-ci.com/g/thecodingmachine/swift-twig-mail-template?b=5.0)
[![Code Coverage](https://scrutinizer-ci.com/g/thecodingmachine/swift-twig-mail-template/badges/coverage.png?branch=5.0)](https://scrutinizer-ci.com/g/thecodingmachine/swift-twig-mail-template?b=5.0)
[![Open Source Love](https://badges.frapsoft.com/os/v1/open-source.svg?v=102)](https://github.com/ellerbrock/open-source-badge/)
[![Open Source Love](https://badges.frapsoft.com/os/mit/mit.svg?v=102)](https://github.com/ellerbrock/open-source-badge/)

# Swift Twig Mail Generator

This package takes a Twig template and generates a Switf mail from this template.

## Installation

```
composer require thecodingmachine/swift-twig-mail-template
```

Once installed, you can start creating an instance of the `SwiftTwigMailTemplate` class.

The `SwiftTwigMailTemplate` represents a mail template that can generate Swift mails.

## Example

Because we consider that an example is better than everything else...

Start by creating your mail template. Your template should have two blocks:

```twig
{% block subject %}
    Your suject
{% endblock %}

{% block body_html %}
    Body with HTML.
{% endblock %}
```

If you want you can add another block containing your text body. This block is optional since we can get your the text body directly from the html one.

```twig
{% block body_text %}
    Body without HTML.
{% endblock %}
```

Now, let's create a `SwiftTwigMailTemplate` instance. This object will generate a `SwiftMail` from the twig template.

```php
// We assume that $twigEnvironment is a valid TwigEnvironment instance
$twigSwiftMailTemplate =  new SwiftTwigMailTemplate($twigEnvironment, 'path/to/template.twig');

// The renderMail method generates a Swift mail object.
$swiftMail = $twigSwiftMailTemplate->renderMail(['paramKey' => paramValue]);

// We fill the swift mail with additional information
$swiftMail->setFrom('sender@example.com');
$swiftMail->setTo('recipient@example.com');

// We assume that $mailer is a valid Swift_Mailer instance
$mailer->send($swiftMail);
```

### Going further

The `SwiftTwigMailTemplate` class has been designed with dependency injection in mind. Instances can be easily put in your container for easy reuse.
Furthermore, the `SwiftTwigMailTemplate` class shares a lot with the `Swift_Mail` class. You can:

* setting the from address 
* setting the from name 
* setting the to address 
* setting the to name 
* setting the Bcc address 
* setting the Bcc name 
* setting the Cc address 
* setting the Cc name 
* setting the ReplyTo address 
* setting the ReplyTo name 
* setting the max line size
* setting the priority
* setting the read receip to
* setting the return path

