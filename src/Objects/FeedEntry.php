<?php

namespace Nazzer\PhpRssParser\Objects;

use DateTime;

readonly class FeedEntry
{
    private ?string $guid;
    private ?string $link;
    private ?string $title;
    private ?string $description;
    private ?DateTime $datePublished;
    private ?DateTime $dateUpdated;

    public function __construct(
        ?string   $guid = null,
        ?string   $link = null,
        ?string   $title = null,
        ?string   $description = null,
        ?DateTime $datePublished = null,
        ?DateTime $dateUpdated = null,
    )
    {
        $this->guid = $guid;
        $this->link = $link;
        $this->title = $title;
        $this->description = $description;
        $this->datePublished = $datePublished;
        $this->dateUpdated = $dateUpdated;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDatePublished(): ?DateTime
    {
        return $this->datePublished;
    }

    public function getDateUpdated(): ?DateTime
    {
        return $this->dateUpdated;
    }
}