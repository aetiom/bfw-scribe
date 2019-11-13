<?php

namespace BfwScribe;

/**
 * BFW-Scribe handler
 *
 * @author Aetiom <aetiom@protonmail.com>
 * @package BFW-Scribe
 * @version 1.0
 */
class Handler 
{
    /**
     * Current langage used to get collection messages
     * @var string
     */
    protected $lang;

    /**
     * Array of registered collections
     * @var array
     */
    protected $collections;



    /**
     * Get current langage
     * @return string current langage
     */
    public function getLang():string
    {
        return $this->lang;
    }

    /**
     * Set current langage
     *
     * @param string $lang : langage to set
     * @return void
     */
    public function setLang(string $lang)
    {
        $this->lang = $lang;
    }

    
    
    /**
     * Constructor
     * @param string $lang : handler default langage
     */
    public function __construct($lang)
    {
        $this->lang = $lang;
    }

    
    
    /**
     * Register collection to be managed by this handler
     *
     * @param string                $name       : collection name
     * @param \BfwScribe\Collection $collection : collection to register
     * 
     * @return void
     */
    public function addCollection(string $name, \BfwScribe\Collection $collection)
    {
        $this->collections[$name] = $collection;
        $collection->setHandler($this);
    }
    
    /**
     * Get collection message
     *
     * @param string $code           : code of data to extract from collection
     * @param string $collectionName : collection name
     * @param array  $context        : array of context to interpolate
     * 
     * @return void
     */
    public function getMessage(string $code, string $collectionName = null, array $context = []) 
    {
        if ($collectionName === null) {
            reset($this->collections);
            $col = current($this->collections);
            
        } else {
            $col = $this->collections[$collectionName];
        }

        $message = $col->getValue($code);
    
        foreach ($context as $key => $val) {
            $message = str_replace($key, $val, $message);
        }
        
        return $message;
    }
    


    /**
     * Get one collection from collection array
     *
     * @param string $name : collection name
     * @return \BfwScribe\Collection : registered collection
     */
    public function getCollection(string $name):\BfwScribe\Collection
    {
        return $this->collection[$name];
    }

}