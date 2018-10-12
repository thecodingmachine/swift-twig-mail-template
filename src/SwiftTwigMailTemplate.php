<?php

namespace TheCodingMachine\Mail\Template;

class SwiftTwigMailTemplate extends AbstractSwiftTwigMailTemplate
{
    /**
     * @var string
     */
    private $twigPath;

    /**
     * SwiftTwigMailTemplate constructor.
     * @param \Twig_Environment $twig_Environment
     * @param string $twigPath
     */
    public function __construct(\Twig_Environment $twig_Environment, string $twigPath)
    {
        parent::__construct($twig_Environment);
        $this->twigPath = $twigPath;
    }

    /**
     * @return \Twig_Template|\Twig_TemplateInterface
     */
    public function getTemplate()
    {
        return $this->twigEnvironment->loadTemplate($this->twigPath);
    }
}