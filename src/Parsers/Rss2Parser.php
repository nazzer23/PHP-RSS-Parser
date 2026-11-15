<?php

namespace Nazzer\PhpRssParser\Parsers;

use Generator;
use Nazzer\PhpRssParser\Helpers\DateTimeHelper;
use Nazzer\PhpRssParser\Interfaces\FeedParserImpl;
use Nazzer\PhpRssParser\Objects\FeedChannel;
use Nazzer\PhpRssParser\Objects\FeedEntry;
use SimpleXMLElement;

class Rss2Parser implements FeedParserImpl
{

    public function parse(SimpleXMLElement $xml): FeedChannel
    {
        $aChannel = $xml->channel;
        return new FeedChannel(
            author: property_exists($aChannel, 'author') ? $aChannel->author : null,
            title: property_exists($aChannel, 'title') ? $aChannel->title : null,
            description: property_exists($aChannel, 'description') ? $aChannel->description : null,
            link: property_exists($aChannel, 'link') ? $aChannel->link : null,
            dateUpdated: property_exists($aChannel, 'lastBuildDate') && DateTimeHelper::isValidDateTime($aChannel->lastBuildDate) ? DateTimeHelper::getDateTime($aChannel->lastBuildDate) : null,
            entries: $this->getEntries($aChannel),
        );
    }

    function getEntries(SimpleXMLElement $xml): Generator
    {
        if (!property_exists($xml, 'item')) {
            yield null;
        }

        foreach ($xml->item as $entry) {
            yield new FeedEntry(
                guid: property_exists($entry, 'guid') ? $entry->guid : null,
                link: property_exists($entry, 'link') ? $entry->link : null,
                title: property_exists($entry, 'title') ? $entry->title : null,
                description: property_exists($entry, 'description') ? $entry->description : null,
                datePublished: property_exists($entry, 'pubDate') && DateTimeHelper::isValidDateTime($entry->pubDate) ? DateTimeHelper::getDateTime($entry->pubDate) : null,
            );
        }
    }
}