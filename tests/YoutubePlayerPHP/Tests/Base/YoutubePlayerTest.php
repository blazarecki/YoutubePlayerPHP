<?php
/**
 * Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 * Date: 06/07/12
 */

namespace YoutubePlayerPHP\Tests\Base;

use YoutubePlayerPHP\Base\YoutubePlayer,
    YoutubePlayerPHP\Helper\YoutubePlayerHelper;

/**
 * YoutubePlayerTest
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class YoutubePlayerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \YoutubePlayerPHP\Base\YoutubePlayer
     */
    private $player;

    /**
     * Create a YoutubePlayerPHP\Tests\Base\YoutubePlayer.
     */
    public function setUp()
    {
        $this->player = new YoutubePlayer();
    }

    /**
     * Delete the YoutubePlayerPHP\Tests\Base\YoutubePlayer.
     */
    public function tearDown()
    {
        unset($this->player);
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::__construct
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getVideoId
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getWidth
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getHeight
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getHtmlContainerId
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getPlayerVars
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setDefaultPlayerVars
     */
    public function testContruct()
    {
        $player = new YoutubePlayer();
        $this->assertEquals('u1zgFlCw8Aw', $player->getVideoId());
        $this->assertEquals(640, $player->getWidth());
        $this->assertEquals(390, $player->getHeight());
        $this->assertEquals('player', $player->getHtmlContainerId());
        $this->assertInternalType('array', $player->getPlayerVars());
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setHtmlContainerId
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getHtmlContainerId
     */
    public function testHtmlContainerId()
    {
        $this->player->setHtmlContainerId('foo');
        $this->assertEquals('foo', $this->player->getHtmlContainerId());
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setVideoId
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getVideoId
     */
    public function testVideoId()
    {
        $this->player->setVideoId('foo');
        $this->assertEquals('foo', $this->player->getVideoId());
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setWidth
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getWidth
     */
    public function testWidth()
    {
        $this->player->setWidth(100);
        $this->assertEquals(100, $this->player->getWidth());
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setWidth
     */
    public function testSetWidthException()
    {
        $this->player->setWidth('not an integer');
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setHeight
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getHeight
     */
    public function testHeight()
    {
        $this->player->setHeight(100);
        $this->assertEquals(100, $this->player->getHeight());
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setHeight
     */
    public function testSetHeightException()
    {
        $this->player->setHeight('not an integer');
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setPlayerVars
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getPlayerVars
     */
    public function testPlayerVars()
    {
        $initialPlayerVars = $this->player->getPlayerVars();
        $this->player->setPlayerVars(array());
        $this->assertEquals($initialPlayerVars, $this->player->getPlayerVars());
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     *
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setPlayerVars
     */
    public function testSetPlayerVarsException()
    {
        $this->player->setPlayerVars(array('foo' => 'bar'));
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setPlayerVar
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getPlayerVar
     */
    public function testPlayerVar()
    {
        $this->player->setPlayerVar('autoplay', 1);
        $this->assertEquals(1, $this->player->getPlayerVar('autoplay'));
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     *
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setPlayerVar
     */
    public function testSetPlayerVarException()
    {
        $this->player->setPlayerVar('foo', 'bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getPlayerVar
     */
    public function testgetPlayerVarException()
    {
        $this->player->getPlayerVar('foo');
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::getPlayerVars
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setDefaultPlayerVars
     */
    public function testInitialPlayerVars()
    {
        foreach ($this->player->getPlayerVars() as $option) {
            $this->assertNull($option);
        }
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setDefaultPlayerVars
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setPlayerVar
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setPlayerVars
     */
    public function testPlayerVarsAllowedTypes()
    {
        try {
            $this->player->setPlayerVar('end', null);
            $this->player->setPlayerVar('end', 123);

            $this->player->setPlayerVar('start', null);
            $this->player->setPlayerVar('start', 123);

            $this->player->setPlayerVar('origin', null);
            $this->player->setPlayerVar('origin', 'foo');

            $this->player->setPlayerVar('playerapiid', null);
            $this->player->setPlayerVar('playerapiid', 'foo');
            $this->player->setPlayerVar('playerapiid', 123);
        } catch (\Symfony\Component\OptionsResolver\Exception\InvalidOptionsException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setDefaultPlayerVars
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setPlayerVar
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::setPlayerVars
     */
    public function testPlayerVarsAllowedValues()
    {
        try {
            $this->player->setPlayerVar('autohide', null);
            $this->player->setPlayerVar('autohide', 0);
            $this->player->setPlayerVar('autohide', 1);
            $this->player->setPlayerVar('autohide', 2);

            $this->player->setPlayerVar('autoplay', null);
            $this->player->setPlayerVar('autoplay', 0);
            $this->player->setPlayerVar('autoplay', 1);

            $this->player->setPlayerVar('cc_load_policy', null);
            $this->player->setPlayerVar('cc_load_policy', 1);

            $this->player->setPlayerVar('color', null);
            $this->player->setPlayerVar('color', 'red');
            $this->player->setPlayerVar('color', 'white');

            $this->player->setPlayerVar('controls', null);
            $this->player->setPlayerVar('controls', 0);
            $this->player->setPlayerVar('controls', 1);

            $this->player->setPlayerVar('disablekb', null);
            $this->player->setPlayerVar('disablekb', 0);
            $this->player->setPlayerVar('disablekb', 1);

            $this->player->setPlayerVar('enablejsapi', null);
            $this->player->setPlayerVar('enablejsapi', 0);
            $this->player->setPlayerVar('enablejsapi', 1);

            $this->player->setPlayerVar('fs', null);
            $this->player->setPlayerVar('fs', 0);
            $this->player->setPlayerVar('fs', 1);

            $this->player->setPlayerVar('iv_load_policy', null);
            $this->player->setPlayerVar('iv_load_policy', 1);
            $this->player->setPlayerVar('iv_load_policy', 3);

            $this->player->setPlayerVar('loop', null);
            $this->player->setPlayerVar('loop', 0);
            $this->player->setPlayerVar('loop', 1);

            $this->player->setPlayerVar('modestbranding', null);
            $this->player->setPlayerVar('modestbranding', 1);

            $this->player->setPlayerVar('rel', null);
            $this->player->setPlayerVar('rel', 0);
            $this->player->setPlayerVar('rel', 1);

            $this->player->setPlayerVar('showinfo', null);
            $this->player->setPlayerVar('showinfo', 0);
            $this->player->setPlayerVar('showinfo', 1);

            $this->player->setPlayerVar('theme', null);
            $this->player->setPlayerVar('theme', 'dark');
            $this->player->setPlayerVar('theme', 'light');
        } catch (\Symfony\Component\OptionsResolver\Exception\InvalidOptionsException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::renderContainer
     */
    public function testRenderContainer()
    {
        $this->assertNotNull($this->player->renderContainer());
        $this->assertInternalType('string', $this->player->renderContainer());
    }

    /**
     * @covers \YoutubePlayerPHP\Base\YoutubePlayer::renderJavaScript
     */
    public function testRenderJavaScript()
    {
        $this->assertNotNull($this->player->renderJavaScript());
        $this->assertInternalType('string', $this->player->renderJavaScript());
    }
}
