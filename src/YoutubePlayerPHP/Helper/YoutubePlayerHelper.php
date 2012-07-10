<?php

/*
 * This file is part of the youtubePlayerPHP package.
 *
 * (c) Benjamin LAZARECKI <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace YoutubePlayerPHP\Helper;

use YoutubePlayerPHP\Base\YoutubePlayer;

/**
 * YoutubePlayerHelper: Helper for YoutubePlayer.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class YoutubePlayerHelper
{
    /**
     * Render HTML for YoutubePlayer.
     *
     * @param string $htmlContainerId The container who contain the player.
     *
     * @return string The generate HTML.
     */
    public function renderContainer($htmlContainerId)
    {
        return sprintf('<div id="%s"></div>'.PHP_EOL, $htmlContainerId);
    }

    /**
     * Render javascript for YoutubePlayer.
     *
     * @param YoutubePlayer\YoutubePlayer $youtubePlayer A instance of YoutubePlayer.
     *
     * @return string The generate javascript.
     */
    public function renderJavaScript(YoutubePlayer $youtubePlayer)
    {
        $js = '<script>' . PHP_EOL;

        $js .= sprintf('
            var tag = document.createElement("script");
            tag.src = "http://www.youtube.com/player_api";
            var firstScriptTag = document.getElementsByTagName("script")[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            function onYouTubePlayerAPIReady()
            {
                var player;
                player = new YT.Player("%s", {
                    width:   %s,
                    height:  %s,
                    videoId: "%s",
                    playerVars: { %s }
                });
             }
             ',
            $youtubePlayer->getHtmlContainerId(),
            $youtubePlayer->getWidth(),
            $youtubePlayer->getHeight(),
            $youtubePlayer->getVideoId(),
            $this->renderPlayerVars($youtubePlayer->getPlayerVars())
        );

        $js .= PHP_EOL . '</script>';

        return $js;
    }

    /**
     * Render Javascript for playerVars.
     *
     * @param array $playerVars PlayerVars of YoutubePlayer
     *
     * @return string The generate javascript.
     */
    private function renderPlayerVars(array $playerVars)
    {
        $generate = array();
        foreach ($playerVars as $key => $value) {
            if ($value !== null) {
                $generate[] = sprintf('%s: %s,', $key, $value);
            }
        }

        return implode(' ', $generate);
    }
}
