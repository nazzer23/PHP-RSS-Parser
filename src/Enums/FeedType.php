<?php

namespace Nazzer\PhpRssParser\Enums;

enum FeedType: string
{
    case ATOM = 'atom';
    case RSS = 'rss';
    case PODCAST = 'podcast';
    case INVALID = 'invalid';
}
