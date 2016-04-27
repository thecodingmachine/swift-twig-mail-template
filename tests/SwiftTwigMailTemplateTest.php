<?php

namespace TheCodingMachine\Mail\Template;

require_once __DIR__.'/../vendor/autoload.php';

class SwiftTwigMailTemplateTest extends \PHPUnit_Framework_TestCase
{
    public function testUnvalidTemplate()
    {
        $twigEnvironnement = new \Twig_Environment(new \Twig_Loader_Filesystem([__DIR__.'/TestTemplate']));
        $swiftTwigMailGenerator = new SwiftTwigMailTemplate($twigEnvironnement, 'UnvalidTemplate.twig');
        $this->expectException(MissingBlockException::class);
        $swiftTwigMailGenerator->getMail();
    }

    public function testValidTemplate()
    {
        $twigEnvironnement = new \Twig_Environment(new \Twig_Loader_Filesystem([__DIR__.'/TestTemplate']));
        $swiftTwigMailGenerator = new SwiftTwigMailTemplate($twigEnvironnement, 'ValidTemplate.twig');
        $swiftTwigMailGenerator->setFromAdresses('shelDon@thecodingmachine.com');
        $swiftTwigMailGenerator->setBccAdresses('shelDon@thecodingmachine.com');
        $swiftTwigMailGenerator->setCcAdresses('shelDon@thecodingmachine.com');
        $swiftTwigMailGenerator->setReturnPath('shelDon@thecodingmachine.com');
        $swiftTwigMailGenerator->setReadReceiptTo('shelDon@thecodingmachine.com');
        $swiftTwigMailGenerator->setReplyToAdresses('shelDon@thecodingmachine.com');
        $swiftTwigMailGenerator->setToAdresses('shelDon@thecodingmachine.com');
        $swiftTwigMailGenerator->setToName('ShelDon');
        $swiftTwigMailGenerator->setFromName('ShelDon');
        $swiftTwigMailGenerator->setBccName('ShelDon');
        $swiftTwigMailGenerator->setCcName('ShelDon');
        $swiftTwigMailGenerator->setReplyToName('ShelDon');
        $swiftTwigMailGenerator->setMaxLineLength(999);
        $swiftTwigMailGenerator->setPriority(1);
        $message = $swiftTwigMailGenerator->renderMail(['name' => 'ShelDon']);

        $this->assertEquals('Welcome to newsletter, ShelDon', $message->getSubject());
        $this->assertEquals('This is the <strong>HTML body</strong>.', $message->getBody());
        $this->assertEquals('This is the text body.', $message->getChildren()[0]->getBody());
        $this->assertEquals(['shelDon@thecodingmachine.com' => 'ShelDon'], $message->getFrom());
        $this->assertEquals(['shelDon@thecodingmachine.com' => 'ShelDon'], $message->getTo());
        $this->assertEquals(['shelDon@thecodingmachine.com' => 'ShelDon'], $message->getBcc());
        $this->assertEquals(['shelDon@thecodingmachine.com' => 'ShelDon'], $message->getCc());
        $this->assertEquals('shelDon@thecodingmachine.com', $message->getReturnPath());
        $this->assertEquals(['shelDon@thecodingmachine.com' => null], $message->getReadReceiptTo());
        $this->assertEquals(['shelDon@thecodingmachine.com' => 'ShelDon'], $message->getReplyTo());
        $this->assertEquals(1, $message->getPriority());
        $this->assertEquals(999, $message->getMaxLineLength());
    }
}
