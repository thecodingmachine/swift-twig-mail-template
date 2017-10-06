<?php


namespace TheCodingMachine\Mail\Template;

use Swift_Message;

class TwigMailExtension extends \Twig_Extension
{
    /**
     * @var Swift_Message[]
     */
    private $messages = [];

    public function pushMessage(Swift_Message $message): void
    {
        $this->messages[] = $message;
    }

    public function popMessage(): Swift_Message
    {
        return array_pop($this->messages);
    }

    private function getMessage(): Swift_Message
    {
        return $this->messages[count($this->messages)-1];
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return \Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('embedImage', [$this, 'embedImage']),
        ];
    }

    public function embedImage(string $imgPath): string
    {
        $message = $this->getMessage();
        return $message->embed(\Swift_Image::fromPath($imgPath));
    }
}