<?php

use Nazzer\PhpRssParser\Enums\FeedType;
use Nazzer\PhpRssParser\Objects\FeedChannel;
use Nazzer\PhpRssParser\Objects\FeedEntry;
use Nazzer\PhpRssParser\RssFeed;
use PHPUnit\Framework\TestCase;

class RssParseTest extends TestCase
{
    public function testRss2Parse(): void
    {
        $sFeed = /** @lang text */
            <<<XML
                <?xml version="1.0" encoding="UTF-8"?>
                <rss version="2.0">
                    <channel>
                      <title>Minimal Blog Feed</title>
                      <link>https://example.com</link>
                      <description>A simple example of an RSS 2.0 feed.</description>
                      
                      <item>
                        <title>First Post</title>
                        <link>https://example.com/first-post</link>
                        <description>This is the description of the first post.</description>
                        <guid>https://example.com/first-post</guid>
                        <pubDate>Mon, 06 Jan 2025 09:00:00 GMT</pubDate>
                      </item>
                    
                    </channel>
                </rss>
                XML;

        $oFeed = RssFeed::parse($sFeed);

        $this->assertInstanceOf(RssFeed::class, $oFeed);
        $this->assertEquals(FeedType::RSS, $oFeed->getFeedType());

        $oFeedChannel = $oFeed->getFeed();

        $this->assertInstanceOf(FeedChannel::class, $oFeedChannel);
        $this->assertEquals("Minimal Blog Feed", $oFeedChannel->getTitle());
        $this->assertEquals("A simple example of an RSS 2.0 feed.", $oFeedChannel->getDescription());
        $this->assertEquals('https://example.com', $oFeedChannel->getLink());

        $oEntry = $oFeedChannel->getEntries()->current();
        $this->assertInstanceOf(FeedEntry::class, $oEntry);
        $this->assertEquals("First Post", $oEntry->getTitle());
        $this->assertEquals("https://example.com/first-post", $oEntry->getLink());
        $this->assertEquals("This is the description of the first post.", $oEntry->getDescription());
        $this->assertEquals('https://example.com/first-post', $oEntry->getGuid());
        $this->assertEquals("Mon, 06 Jan 2025 09:00:00 GMT", $oEntry->getDatePublished()?->format('D, d M Y H:i:s T'));
    }

    public function testAtomParse(): void
    {
        $sFeed = /** @lang text */
            <<<XML
                <?xml version="1.0" encoding="utf-8"?>
                <feed xmlns="http://www.w3.org/2005/Atom">
                
                  <title>Example Atom Feed</title>
                  <link href="http://example.org/"/>
                  <updated>2025-01-16T18:30:02Z</updated>
                  <author>
                    <name>John Doe</name>
                  </author>
                  <id>urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6</id>
                
                  <entry>
                    <title>Atom-Powered Robots Run Amok</title>
                    <link href="http://example.org/2025/01/16/atom03"/>
                    <id>urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</id>
                    <updated>2025-01-16T18:30:02Z</updated>
                    <summary>Some text.</summary>
                  </entry>
                
                </feed>

                XML;

        $oFeed = RssFeed::parse($sFeed);

        $this->assertInstanceOf(RssFeed::class, $oFeed);
        $this->assertEquals(FeedType::ATOM, $oFeed->getFeedType());

        $oFeedChannel = $oFeed->getFeed();

        $this->assertInstanceOf(FeedChannel::class, $oFeedChannel);
        $this->assertEquals("urn:uuid:60a76c80-d399-11d9-b93C-0003939e0af6", $oFeedChannel->getId());
        $this->assertEquals("Example Atom Feed", $oFeedChannel->getTitle());
        $this->assertEquals('http://example.org/', $oFeedChannel->getLink());
        $this->assertEquals("2025-01-16T18:30:02Z", $oFeedChannel->getDateUpdated()?->format('Y-m-d\TH:i:sp'));


        $oEntry = $oFeedChannel->getEntries()->current();
        $this->assertInstanceOf(FeedEntry::class, $oEntry);
        $this->assertEquals("Atom-Powered Robots Run Amok", $oEntry->getTitle());
        $this->assertEquals("http://example.org/2025/01/16/atom03", $oEntry->getLink());
        $this->assertEquals("Some text.", $oEntry->getDescription());
        $this->assertEquals('urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a', $oEntry->getGuid());
        $this->assertEquals("2025-01-16T18:30:02Z", $oEntry->getDateUpdated()?->format('Y-m-d\TH:i:sp'));
    }

    public function testPodcastParse(): void
    {
        $sFeed = /** @lang text */
            <<<XML
                <?xml version="1.0" encoding="UTF-8"?>
                <rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:content="http://purl.org/rss/1.0/modules/content/">
                  <channel>
                    <title>My Awesome Podcast</title>
                    <link>https://example.com/podcast</link>
                    <language>en-us</language>
                    <copyright>&#169; 2025 My Brand</copyright>
                    <itunes:author>John Doe</itunes:author>
                    <itunes:summary>A podcast about technology and life.</itunes:summary>
                    <description>A podcast about technology and life.</description>
                    <itunes:owner>
                      <itunes:name>John Doe</itunes:name>
                      <itunes:email>john@example.com</itunes:email>
                    </itunes:owner>
                    <itunes:image href="https://example.com/podcasts/image.jpg" />
                    <itunes:category text="Technology" />
                    <itunes:explicit>false</itunes:explicit>
                
                    <item>
                      <title>Episode 1: The Beginning</title>
                      <itunes:episode>1</itunes:episode>
                      <itunes:season>1</itunes:season>
                      <itunes:episodeType>full</itunes:episodeType>
                      <description>We start our journey into the tech world.</description>
                      <enclosure length="498537" type="audio/mpeg" url="http://example.com/podcasts/episode1.mp3" />
                      <guid>https://example.com/podcasts/episode1.mp3</guid>
                      <pubDate>Tue, 07 Jan 2025 08:00:00 GMT</pubDate>
                      <itunes:duration>1024</itunes:duration>
                      <itunes:explicit>false</itunes:explicit>
                    </item>
                  </channel>
                </rss>
                XML;

        $oFeed = RssFeed::parse($sFeed);

        $this->assertInstanceOf(RssFeed::class, $oFeed);
        $this->assertEquals(FeedType::PODCAST, $oFeed->getFeedType());
    }

    public function testInvalidFeedParse(): void
    {
        $sFeed = <<<HTML
                <html lang="en">
                    <head>
                        <title>Malformed Feed</title>
                    </head>
                    <body>
                        <h1>Hello World</h1>
                    </body>
                </html>
                HTML;

        $oFeed = RssFeed::parse($sFeed);
        $this->assertNull($oFeed);
    }

    public function testInvalidParse(): void
    {
        $sFeed = "Hello World";
        $oOutput = RssFeed::parse($sFeed);
        $this->assertNull($oOutput);
    }
}
