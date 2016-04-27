<?php

namespace TheCodingMachine\Mail\Template;


use TheCodingMachine\Mail\SwiftMailTemplate;

class SwiftTwigMailTemplate implements SwiftMailTemplate
{
    /**
     * @var \Twig_Environment
     */
    protected $twigEnvironment;

    /**
     * @var string
     */
    protected $twigPath;

    /**
     * @var string|array
     */
    protected $fromAdresses;

    /**
     * @var string
     */
    protected $fromName = null;

    /**
     * @var string|array
     */
    protected $toAdresses;

    /**
     * @var string
     */
    protected $toName = null;

    /**
     * @var string|array
     */
    protected $bccAdresses;

    /**
     * @var string
     */
    protected $bccName = null;

    /**
     * @var string|array
     */
    protected $ccAdresses;

    /**
     * @var string
     */
    protected $ccName = null;

    /**
     * @var string|array
     */
    protected $replyToAdresses;

    /**
     * @var string
     */
    protected $replyToName = null;

    /**
     * @var int
     */
    protected $maxLineLength = 1000;

    /**
     * @var int
     */
    protected $priority;

    /**
     * @var string
     */
    protected $readReceiptTo;

    /**
     * @var string
     */
    protected $returnPath;

    /**
     * SwiftTwigMailGenerator constructor.
     *
     * @param \Twig_Environment $twig_Environment
     * @param string            $twigPath
     */
    public function __construct(\Twig_Environment $twig_Environment, string $twigPath)
    {
        $this->twigEnvironment = $twig_Environment;
        $this->twigPath = $twigPath;
    }

    /**
     * @param array $data
     *
     * @return \Swift_Message
     */
    public function renderMail(array $data = []) :\Swift_Message
    {
        $mail = new \Swift_Message();

        $twigEnvironment = clone $this->twigEnvironment;
        $function = new \Twig_SimpleFunction('embedImage', function ($imgPath) use ($mail) {
            return $mail->embed(\Swift_Image::fromPath($imgPath));
        });
        $twigEnvironment->addFunction($function);

        $template = $twigEnvironment->loadTemplate($this->twigPath);

        if (!$template->hasBlock('subject') || !$template->hasBlock('body_html') || !$template->hasBlock('body_text')) {
            //TODO extract body_text from body HTML
            throw MissingBlockException::missingBlock($template->getBlockNames());
        }

        $subject  = $template->renderBlock('subject', $data);
        $bodyHtml = $template->renderBlock('body_html', $data);
        $bodyText = $template->renderBlock('body_text', $data);

        $mail->setSubject($subject);
        $mail->setBody($bodyHtml);
        $mail->addPart($bodyText);

        if ($this->fromAdresses) {
            $mail->setFrom($this->fromAdresses, $this->fromName);
            $mail->setSender($this->fromAdresses, $this->fromName);
        }

        if ($this->toAdresses) {
            $mail->setTo($this->toAdresses, $this->toName);
        }

        if ($this->bccAdresses) {
            $mail->setBcc($this->bccAdresses, $this->bccName);
        }
        if ($this->ccAdresses) {
            $mail->setCc($this->ccAdresses, $this->ccName);
        }
        if ($this->replyToAdresses) {
            $mail->setReplyTo($this->replyToAdresses, $this->replyToName);
        }

        if ($this->maxLineLength) {
            $mail->setMaxLineLength($this->maxLineLength);
        }
        if ($this->priority) {
            $mail->setPriority($this->priority);
        }

        if ($this->readReceiptTo) {
            $mail->setReadReceiptTo($this->readReceiptTo);
        }

        if ($this->returnPath) {
            $mail->setReturnPath($this->returnPath);
        }

        return $mail;
    }

    /**
     * @param array|string $fromAdresses
     */
    public function setFromAdresses($fromAdresses)
    {
        $this->fromAdresses = $fromAdresses;
    }

    /**
     * @param string $fromName
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;
    }

    /**
     * @param array|string $toAdresses
     */
    public function setToAdresses($toAdresses)
    {
        $this->toAdresses = $toAdresses;
    }

    /**
     * @param string $toName
     */
    public function setToName($toName)
    {
        $this->toName = $toName;
    }

    /**
     * @param array|string $bccAdresses
     */
    public function setBccAdresses($bccAdresses)
    {
        $this->bccAdresses = $bccAdresses;
    }

    /**
     * @param string $bccName
     */
    public function setBccName($bccName)
    {
        $this->bccName = $bccName;
    }

    /**
     * @param array|string $ccAdresses
     */
    public function setCcAdresses($ccAdresses)
    {
        $this->ccAdresses = $ccAdresses;
    }

    /**
     * @param string $ccName
     */
    public function setCcName($ccName)
    {
        $this->ccName = $ccName;
    }

    /**
     * @param array|string $replyToAdresses
     */
    public function setReplyToAdresses($replyToAdresses)
    {
        $this->replyToAdresses = $replyToAdresses;
    }

    /**
     * @param string $replyToName
     */
    public function setReplyToName($replyToName)
    {
        $this->replyToName = $replyToName;
    }

    /**
     * @param int $maxLineLength
     */
    public function setMaxLineLength($maxLineLength)
    {
        $this->maxLineLength = $maxLineLength;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @param string $readReceiptTo
     */
    public function setReadReceiptTo($readReceiptTo)
    {
        $this->readReceiptTo = $readReceiptTo;
    }

    /**
     * @param string $returnPath
     */
    public function setReturnPath($returnPath)
    {
        $this->returnPath = $returnPath;
    }
}
