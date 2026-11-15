<?php

namespace Nazzer\PhpRssParser\Objects;

use DateTime;
use Generator;

readonly class FeedChannel
{
    private ?string $id;
    private ?string $author;
    private ?string $title;
    private ?string $description;
    private ?string $link;

    private ?DateTime $dateUpdated;

    private ?Generator $entriesGenerator;

    public function __construct(
        ?string    $id = null,
        ?string    $author = null,
        ?string    $title = null,
        ?string    $description = null,
        ?string    $link = null,
        ?DateTime  $dateUpdated = null,
        ?Generator $entries = null
    )
    {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->description = $description;
        $this->link = $link;
        $this->dateUpdated = $dateUpdated;

        $this->entriesGenerator = $entries;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getDateUpdated(): ?DateTime
    {
        return $this->dateUpdated;
    }

    public function getEntries(): Generator
    {
        return $this->entriesGenerator;
    }
}