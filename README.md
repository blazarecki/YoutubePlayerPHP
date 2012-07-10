# YoutubePlayerPHP [![Build Status](https://secure.travis-ci.org/benjaminlazarecki/YoutubePlayerPHP.png)](http://travis-ci.org/benjaminlazarecki/YoutubePlayerPHP)

It's allow you to create a youtube player and render it.

### How to use

#### Create a youtube player

```php
<?php
$youtubePlayer = new YoutubePlayer();
```

#### Customize the youtube player

```php
<?php
$youtubePlayer->setVideoId('IUGzY-ihqWc');
$youtubePlayer->setHtmlContainerId('player');
$youtubePlayer->setWidth(800);
$youtubePlayer->setHeight(600);
```

You can also customize the youtube player in constructor

```php
<?php
$youtubePlayer = new YoutubePlayer('u1zgFlCw8Aw', 800, 600, 'player');
```

By default if you call a the YoutubePlayer constructor without args, container id is 'player' width is set to 640 and height to 390.

#### It's ready to use

```php
<?php
$youtubePlayer->renderContainer();
$youtubePlayer->renderJavaScript();
```

Those methods generate the html and the javascript to render the youtube player.

It's generate
```html
<div id="player"></div>
<script>
    var tag = document.createElement("script");
    tag.src = "http://www.youtube.com/player_api";
    var firstScriptTag = document.getElementsByTagName("script")[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    function onYouTubePlayerAPIReady()
    {
        var player;
        player = new YT.Player("player", {
            width:   640,
            height:  390,
            videoId: "IUGzY-ihqWc",
        });
     }
</script>
```

#### Add some options

```php
<?php
$youtubePlayer->setPlayerVar('autohide', 1);
$youtubePlayer->setPlayerVars(array(
    'controls' => 1,
    'autoplay' => 1,
    'loop'     => 0,
    'theme'    => 'light',
));
```

For all options see the [official doc]( https://developers.google.com/youtube/player_parameters)

