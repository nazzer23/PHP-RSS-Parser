<?php

namespace Nazzer\PhpRssParser\Parsers;

use Generator;
use Nazzer\PhpRssParser\Interfaces\FeedParserImpl;
use SimpleXMLElement;

class Rss2Parser implements FeedParserImpl
{

    public function parse(SimpleXMLElement $xml): Generator
    {
        // TODO: Implement parse() method.
    }
}