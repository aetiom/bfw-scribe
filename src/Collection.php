<?php

namespace BfwScribe;

use \Aetiom\PhpUtils\Asset;

/**
 * BFW-Scribe collection
 *
 * @author Aetiom <aetiom@protonmail.com>
 * @package BFW-Scribe
 * @version 1.0
 */
class Collection 
{
    /**
     * Asset that contains collection data
     * @var \Aetiom\PhpUtils\Asset
     */
    protected $asset;

    /**
     * Handler where this collection is registered
     * @var \BfwScribe\Handler
     */
    protected $handler;



    /**
     * Get asset
     * @return \Aetiom\PhpUtils\Asset
     */
    public function getAsset():\Aetiom\PhpUtils\Asset
    {
        return $this->asset;
    }

    /**
     * Get handler
     * @return \BfwScribe\Handler
     */
    public function getHandler():Handler
    {
        return $this->handler;
    }

    /**
     * Set handler
     *
     * @param \BfwScribe\Handler $handler : collection handler
     * @return void
     */
    public function setHandler(Handler $handler)
    {
        $this->handler = $handler;
    }

    
    
    /**
     * Constructor
     *
     * @param string $name  : collection name
     * @param array  $asset : main asset as array
     */
    public function __construct(string $name, array $asset = array())
    {
        $this->asset = new Asset($name);

        if (!empty($asset)) {
            $this->asset->update($asset);
        }
    }

    
    
    /**
     * Add asset
     *
     * @param string $chainedKeys : chained asset keys (with '.' as link)
     * @param array  $asset       : additional asset as array
     * @return void
     */
    public function addAsset(string $chainedKeys, array $asset)
    {
        $this->selectAsset($chainedKeys)->update($asset);
    }



    /**
     * Get asset data value
     *
     * @param string $chainedKeys : chained asset keys (with '.' as link)
     * @param string $forceLang   : langage used to get value instead of handler langage
     * @return void
     */
    public function getValue(string $chainedKeys, string $forceLang = null)
    {
        $response = $this->selectAsset($chainedKeys)->fetch();

        if (is_array($response)) {
            
            if ($forceLang !== null) {
                $lang = $forceLang;
            } elseif ($this->handler !== null) {
                $lang = $this->handler->getLang();
            } else {
                return current($response);
            }

            $response = $this->selectAsset($chainedKeys)->fetch($lang);
        }

        return $response;
    }



    /**
     * Select asset recursivly
     *
     * @param string $chainedKeys : chained asset keys (with '.' as link)
     * @return void
     */
    protected function selectAsset(string $chainedKeys)
    {
        $keys = explode('.', $chainedKeys);
        

        $asset = $this->asset;
        foreach ($keys as $k) {
            $asset = $asset->select($k);
        }
        
        return $asset;
    }
}