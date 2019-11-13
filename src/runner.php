<?php

$config = $this->getConfig();

// Create main collection handler and set local to default langage value
$this->handler = new BfwScribe\Handler($config->getValue('defaultLang', 'config.php'));



// Create and load each collection in collection handler
$colList = $config->getValue('collections', 'config.php');

foreach ($colList as $colName => $colFile) {
    $col = new BfwScribe\Collection($colName, $config->getValue($colName, $colFile));
    $this->handler->addCollection($colName, $col);
}



// Load Scribe Twig Extension of BFW-Twig is loaded
$app = \BFW\Application::getInstance();

if ($app->getModuleList()->hasModule('bfw-twig')) {
    $bfwTwig = $app->getModuleList()->getModuleByName('bfw-twig');

    $scribeExt = new \BfwScribe\Twig\ScribeExtension();
    $bfwTwig->twig->addExtension($scribeExt);
}