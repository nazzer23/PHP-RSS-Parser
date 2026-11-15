<?php

namespace Nazzer\PhpRssParser;

use Nazzer\PhpRssParser\Enums\FeedType;
use Nazzer\PhpRssParser\Objects\FeedChannel;
use Nazzer\PhpRssParser\Parsers\AtomParser;
use Nazzer\PhpRssParser\Parsers\PodcastParser;
use Nazzer\PhpRssParser\Parsers\Rss2Parser;
use SimpleXMLElement;

class RssFeed
{
    private FeedType $feedType;
    private SimpleXMLElement $oXml;

    public function __construct(FeedType $feedType, SimpleXMLElement $xml)
    {
        $this->feedType = $feedType;
        $this->oXml = $xml;
    }

    public function getFeedType(): FeedType
    {
        return $this->feedType;
    }

    public function getFeed(): ?FeedChannel
    {
        // Determine which Parser to use
        $feedParser = match ($this->feedType) {
            FeedType::ATOM => new AtomParser,
            FeedType::RSS => new Rss2Parser,
            FeedType::PODCAST => new PodcastParser,
            default => null,
        };

        return $feedParser?->parse($this->oXml);

    }

    public static function parse(string $sFeed): ?RssFeed
    {
        // Attempt to read the XML input
        $oSimpleXml = simplexml_load_string($sFeed);

        if ($oSimpleXml === false) {
            return null;
        }

        $oFeedType = self::detectFeedType($oSimpleXml);
        if ($oFeedType === FeedType::INVALID) {
            return null;
        }

        // Create the RSS Feed Object using the correct parser
        return new self($oFeedType, $oSimpleXml);
    }

    private static function detectFeedType(SimpleXMLElement $element): FeedType
    {
        $sFirstElementName = $element->getName();

        // if name === feed, we can early return the assumption of atom.
        if (strtolower($sFirstElementName) === 'feed') {
            return FeedType::ATOM;
        }

        if (strtolower($sFirstElementName) === 'rss') {
            // Now, we need to check if it's RSS or Podcast...
            $aNamespaces = $element->getNamespaces(true);
            $aNamespaces = array_keys($aNamespaces);
            $aNamespaces = array_map(fn(string $sNamespace) => strtolower($sNamespace), $aNamespaces);
            if (in_array('itunes', $aNamespaces)) {
                return FeedType::PODCAST;
            }

            return FeedType::RSS;
        }

        return FeedType::INVALID;
    }
}