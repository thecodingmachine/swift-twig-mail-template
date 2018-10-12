<?php

namespace TheCodingMachine\Mail\Template;

class SwiftTwigMailString extends AbstractSwiftTwigMailTemplate
{
    /**
     * @var string
     */
    private $twigContent;

    /**
     * SwiftTwigMailString constructor.
     * @param \Twig_Environment $twig_Environment
     * @param string $twigContent
     */
    public function __construct(\Twig_Environment $twig_Environment, string $twigContent)
    {
        parent::__construct($twig_Environment);
        $this->twigContent = $twigContent;
    }

    /**
     * @return \Twig_Template
     */
    public function getTemplate()
    {
        return $this->twigEnvironment->createTemplate($this->twigContent);
    }
}