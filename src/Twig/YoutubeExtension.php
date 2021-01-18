<?php

namespace App\Twig;

use RicardoFiorani\Matcher\VideoServiceMatcher;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class YoutubeExtension extends AbstractExtension
{
    private $youtubeParser;

    /**
     * YoutubeExtension constructor.
     */
    public function __construct()
    {
        $this->youtubeParser = new VideoServiceMatcher();
    }


    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('youtube_thumbnail', [$this, 'youtubeThumbnail']),
            new TwigFilter('youtube_player', [$this, 'youtubePlayer'])
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function youtubeThumbnail($url)
    {
        //Parser l'url et recup le resultat
        $video = $this->youtubeParser->parse($url);
        return $video->getMediumThumbnail();
    }

    public function youtubePlayer($url)
    {
        //Parser l'url et recup le resultat
        $video = $this->youtubeParser->parse($url);
        return $video->getEmbedCode('100%',500,true,true );
    }
}
