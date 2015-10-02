<?php

namespace C2iS\Component\Json;

use Peekmo\JsonPath\JsonStore;

/**
 * Iterate over Json from a string or an array. Uses JsonPath to identify which nodes should be iterated upon.
 *
 * Class JsonIterator
 * @package C2iS\Component\Json
 */
class JsonIterator implements \Iterator, \Countable
{
    /** @var string */
    protected $content;

    /** @var \DOMDocument */
    protected $currentContent;

    /** @var string */
    protected $jsonpath;

    /**
     * @param objects/arrays/ArrayAccess-objects $input string input, passed by reference
     * @param string $jsonpath The JSONPath to identify which nodes should be iterated upon.
     */
    public function __construct($input, $jsonpath)
    {
        $this->content = $input;
        $this->jsonpath = $jsonpath;

        $this->rewind();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->content = (new JsonStore($this->content))->get($this->jsonpath);
        $this->content = (new JsonStore($this->content))->toArray();
        $this->currentContent = (new JsonStore($this->content))->toArray();
    }

    /**
    * @inheritdoc
    */
    public function current()
    {
        $currentElement = $this->getCurrentElement();

        return $currentElement ? $currentElement : null;
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        if (is_array($this->currentContent[0]))
            array_shift($this->currentContent[0]);
        else
            array_shift($this->currentContent);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return (boolean) $this->getCurrentElement();
    }

    /**
     * @return Array|null
     */
    public function getCurrentElement()
    {
        if (count($this->currentContent) != 0) {
            if (count($this->content) != 0 && is_array($this->currentContent[0]) && count($this->currentContent[0]) != 0)
                return $this->currentContent[0][0];
            else
                return $this->currentContent[0];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getJsonPath()
    {
        return $this->jsonpath;
    }

    /**
     * @return integer
     */
    public function count()
    {
        if (count($this->content) != 0 && is_array($this->content[0]))
            return count($this->content[0]);
        return count($this->content);
    }
}
