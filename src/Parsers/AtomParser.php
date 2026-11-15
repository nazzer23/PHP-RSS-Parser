<?php

namespace Nazzer\PhpRssParser\Parsers;

use Generator;
use Nazzer\PhpRssParser\Helpers\DateTimeHelper;
use Nazzer\PhpRssParser\Interfaces\FeedParserImpl;
use Nazzer\PhpRssParser\Objects\FeedChannel;
use Nazzer\PhpRssParser\Objects\FeedEntry;
use SimpleXMLElement;

class AtomParser implements FeedParserImpl
{

    public function parse(SimpleXMLElement $xml): FeedChannel
    {
        return new FeedChannel(
            id: property_exists($xml, 'id') ? $xml->id : null,
            author: property_exists($xml, 'author') ? $xml->author?->name : null,
            title: property_exists($xml, 'title') ? $xml->title : null,
            description: property_exists($xml, 'description') ? $xml->description : null,
            link: property_exists($xml, 'link') ? $xml->link['href'] : null,
            dateUpdated: property_exists($xml, 'updated') && DateTimeHelper::isValidDateTime($xml->updated) ? DateTimeHelper::getDateTime($xml->updated) : null,

            entries: $this->getEntries($xml),
        );
    }

    function getEntries(SimpleXMLElement $xml): Generator
    {
        if (!property_exists($xml, 'entry')) {
            yield null;
        }

        foreach ($xml->entry as $entry) {
            yield new FeedEntry(
                guid: property_exists($entry, 'id') ? $entry->id : null,
                link: property_exists($entry, 'link') ? $entry->link['href'] : null,
                title: property_exists($entry, 'title') ? $entry->title : null,
                description: property_exists($entry, 'summary') ? $entry->summary : null,
                dateUpdated: property_exists($entry, 'updated') && DateTimeHelper::isValidDateTime($entry->updated) ? DateTimeHelper::getDateTime($entry->updated) : null,
            );
        }
    }
}