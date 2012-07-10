<?php

/*
 * This file is part of the youtubePlayerPHP package.
 *
 * (c) Benjamin LAZARECKI <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace YoutubePlayerPHP\Base;

use Symfony\Component\OptionsResolver\OptionsResolver,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\OptionsResolver\Options;

use YoutubePlayerPHP\Helper\YoutubePlayerHelper;

/**
 * YoutubePlayer: represent a youtube player.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class YoutubePlayer
{
    /**
     * @var string HTML container id.
     */
    private $htmlContainerId;

    /**
     * @var string Video id.
     */
    private $videoId;

    /**
     * @var int Player width.
     */
    private $width;

    /**
     * @var int Player height.
     */
    private $height;

    /**
     * @var array Some options for the YoutubePlayer
     *
     * @link https://developers.google.com/youtube/player_parameters
     */
    private $playerVars;

    /**
     * @var \YoutubePlayerPHP\Helper\YoutubePlayerHelper Helper for YoutubePlayer.
     */
    private $helper;

    /**
     * @var \Symfony\Component\OptionsResolver\OptionsResolver Option resolver for playerVars.
     */
    private $playerVarsResolver;

    /**
     * Constuct.
     *
     * @param string $videoId         HTML container id.
     * @param int    $width           Player width.
     * @param int    $height          Player height.
     * @param string $htmlContainerId Video id.
     * @param array  $playerVars      Some options for the YoutubePlayer
     */
    public function __construct(
        $videoId = 'u1zgFlCw8Aw',
        $width = 640,
        $height = 390,
        $htmlContainerId = 'player',
        $playerVars = array()
    )
    {
        $this->setVideoId($videoId);
        $this->setHtmlContainerId($htmlContainerId);
        $this->setWidth($width);
        $this->setHeight($height);
        $this->helper = new YoutubePlayerHelper();
        $this->playerVarsResolver = new OptionsResolver();
        $this->setDefaultPlayerVars($this->playerVarsResolver);
        $this->playerVars = $this->playerVarsResolver->resolve($playerVars);
    }

    /**
     * Set the HTML container id.
     *
     * @param string $htmlContainerId HTML container id.
     *
     * @return \YoutubePlayerPHP\Base\YoutubePlayer The current YoutubePlayer.
     */
    public function setHtmlContainerId($htmlContainerId)
    {
        $this->htmlContainerId = $htmlContainerId;

        return $this;
    }

    /**
     * Get HTML container id.
     *
     * @return string HTML container id.
     */
    public function getHtmlContainerId()
    {
        return $this->htmlContainerId;
    }

    /**
     * Set video id.
     *
     * @param string $videoId A video id.
     *
     * @return \YoutubePlayerPHP\Base\YoutubePlayer The current YoutubePlayer.
     */
    public function setVideoId($videoId)
    {
        // TODO validateur d'id.
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * Get video id.
     *
     * @return string Video id.
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Set player width.
     *
     * @param int $width Player width.
     *
     * @return \YoutubePlayerPHP\Base\YoutubePlayer The current YoutubePlayer.
     *
     * @throws \InvalidArgumentException throw when $width is not an integer.
     */
    public function setWidth($width)
    {
        if (!is_integer($width)) {
            throw new \InvalidArgumentException(sprintf(
                'Argument pass to setWidth must be be an integer. Passed : type %s, value %s',
                gettype($width),
                $width
            ));
        }

        $this->width = $width;

        return $this;
    }

    /**
     * Get player width.
     *
     * @return int Player width.
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set player height.
     *
     * @param int $height Player height.
     *
     * @return \YoutubePlayerPHP\Base\YoutubePlayer The current YoutubePlayer.
     *
     * @throws \InvalidArgumentException
     */
    public function setHeight($height)
    {
        if (!is_integer($height)) {
            throw new \InvalidArgumentException(sprintf(
                'Argument pass to setHeight must be be an integer. Passed : type %s, value %s',
                gettype($height),
                $height
            ));
        }

        $this->height = $height;

        return $this;
    }

    /**
     * Get player height.
     *
     * @return int Player height.
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set playerVars.
     *
     * @param array $playerVars an array of playerVar
     *
     * @see   \YoutubePlayerPHP\Base\YoutubePlayer::setDefaultPlayerVars
     * @link  https://developers.google.com/youtube/player_parameters
     *
     * @return \YoutubePlayerPHP\Base\YoutubePlayer The current YoutubePlayer.
     */
    public function setPlayerVars(array $playerVars)
    {
        $this->playerVars = $this->playerVarsResolver->resolve(
            array_merge(
                $this->playerVars,
                $playerVars
            )
        );

        return $this;
    }

    /**
     * Set playerVar.
     *
     * @param string $playerVar The playerVar.
     * @param mixed  $value     The value of the playerVar.
     *
     * @return \YoutubePlayerPHP\Base\YoutubePlayer The current YoutubePlayer.
     */
    public function setPlayerVar($playerVar, $value)
    {
        $this->setPlayerVars(array($playerVar => $value));

        return $this;
    }

    /**
     * Get playerVars.
     *
     * @return array
     */
    public function getPlayerVars()
    {
        return $this->playerVars;
    }

    /**
     * Get playerVar.
     *
     * @param string $playerVar A playerVar.
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function getPlayerVar($playerVar)
    {
        if ($this->playerVarsResolver->isKnown($playerVar)) {
            return $this->playerVars[$playerVar];
        }

        throw new \InvalidArgumentException(sprintf(
            'Argument pass to getPlayerVar is not a know options. Passed : %s',
            $playerVar
        ));
    }

    /**
     * Render container.
     *
     * @return string
     */
    public function renderContainer()
    {
        return $this->helper->renderContainer($this->htmlContainerId);
    }

    /**
     * Render javascript.
     *
     * @return string
     */
    public function renderJavaScript()
    {
        return $this->helper->renderJavaScript($this);
    }

    /**
     * Init the Symfony OptionResolver for playerVars.
     *
     * @param \OptionsResolverInterface $resolver
     */
    private function setDefaultPlayerVars(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'autohide'       => null,
            'autoplay'       => null,
            'cc_load_policy' => null,
            'color'          => null,
            'controls'       => null,
            'disablekb'      => null,
            'enablejsapi'    => null,
            'end'            => null,
            'fs'             => null,
            'iv_load_policy' => null,
            'loop'           => null,
            'modestbranding' => null,
            'origin'         => null,
            'playerapiid'    => null,
            'rel'            => null,
            'showinfo'       => null,
            'start'          => null,
            'theme'          => null,
        ));

        $resolver->setAllowedTypes(array(
            'end'         => array('null', 'integer'),
            'origin'      => array('null', 'string'),
            'playerapiid' => array('null', 'string', 'integer'),
            'start'       => array('null', 'integer'),

        ));

        $resolver->setAllowedValues(array(
            'autohide'       => array(null, 0, 1, 2),
            'autoplay'       => array(null, 0, 1),
            'cc_load_policy' => array(null, 1),
            'color'          => array(null, 'red', 'white'),
            'controls'       => array(null, 0, 1),
            'disablekb'      => array(null, 0, 1),
            'enablejsapi'    => array(null, 0, 1),
            'fs'             => array(null, 0, 1),
            'iv_load_policy' => array(null, 1, 3),
            'loop'           => array(null, 0, 1),
            'modestbranding' => array(null, 1),
            'rel'            => array(null, 0, 1),
            'showinfo'       => array(null, 0, 1),
            'theme'          => array(null, 'dark', 'light'),
        ));
    }
}
