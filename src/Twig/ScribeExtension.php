<?php

namespace BfwScribe\Twig;

class ScribeExtension extends \Twig\Extension\AbstractExtension
{
    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('scribe'        , [$this, 'getMessage']),
            new \Twig\TwigFunction('scribeSetLang', [$this, 'setLang']),
            new \Twig\TwigFunction('scribeGetLang', [$this, 'getLang']),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('scribe', [$this, 'getMessage']),
        ];
    }

    public function getMessage(string $code, string $collectionName = null, array $context = array())
    {
        $app = \BFW\Application::getInstance();
        $bfwScribe = $app->getModuleList()->getModuleByName('bfw-scribe');

        return $bfwScribe->handler->getMessage($code, $collectionName, $context);
    }

    public function setLang(string $lang)
    {
        $app = \BFW\Application::getInstance();
        $bfwScribe = $app->getModuleList()->getModuleByName('bfw-scribe');

        $bfwScribe->handler->setLang($lang);
    }

    public function getLang()
    {
        $app = \BFW\Application::getInstance();
        $bfwScribe = $app->getModuleList()->getModuleByName('bfw-scribe');

        return $bfwScribe->handler->getLang();
    }
}