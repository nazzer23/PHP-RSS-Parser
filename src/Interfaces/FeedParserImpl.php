<?php

namespace Nazzer\PhpRssParser\Interfaces;

use Generator;
use Nazzer\PhpRssParser\Objects\FeedChannel;
use SimpleXMLElement;

interface FeedParserImpl
{
    public function parse(SimpleXMLElement $xml): FeedChannel;

    function getEntries(SimpleXMLElement $xml): Generator;
}