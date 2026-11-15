<?php

namespace Nazzer\PhpRssParser\Interfaces;

use Generator;
use SimpleXMLElement;

interface FeedParserImpl
{
    public function parse(SimpleXMLElement $xml): Generator;
}