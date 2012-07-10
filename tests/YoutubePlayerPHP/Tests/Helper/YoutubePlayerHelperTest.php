<?php
/**
 * Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 * Date: 10/07/12
 */

namespace YoutubePlayerPHP\Tests\Helper;

use YoutubePlayerPHP\Base\YoutubePlayer,
    YoutubePlayerPHP\Helper\YoutubePlayerHelper;

/**
 * YoutubePlayerHelperTest
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class YoutubePlayerHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \YoutubePlayerPHP\Helper\YoutubePlayerHelper
     */
    private $helper;

    /**
     * Create a YoutubePlayerPHP\Helper\YoutubePlayerHelper.
     */
    public function setUp()
    {
        $this->helper = new YoutubePlayerHelper();
    }

    /**
     * Delete the YoutubePlayerPHP\Tests\Base\YoutubePlayer.
     */
    public function tearDown()
    {
        unset($this->helper);
    }

    /**
     * @covers \YoutubePlayerPHP\Helper\YoutubePlayerHelper::renderContainer
     */
    public function testRenderContainer()
    {
        $result = $this->helper->renderContainer('foo');
        $this->assertInternalType('string', $result);
    }

    /**
     * @covers \YoutubePlayerPHP\Helper\YoutubePlayerHelper::renderJavaScript
     */
    public function testRenderJavascript()
    {
        $result = $this->helper->renderJavaScript(new YoutubePlayer());
        $this->assertInternalType('string', $result);
    }

    /**
     * @covers \YoutubePlayerPHP\Helper\YoutubePlayerHelper::renderPlayerVars
     */
    public function testRenderPlayerVars()
    {
        $reflectionHelper = new \ReflectionObject(new YoutubePlayerHelper());
        $method = $reflectionHelper->getMethod('renderPlayerVars');
        $method->setAccessible(true);
        $helper = new YoutubePlayerHelper();

        $playerVars = array(
            'foo1' => 'bar',
            'foo2' => null,
            'foo3' => 1,
        );

        $this->assertContains('foo1', $method->invoke($helper, $playerVars));
        $this->assertContains('bar', $method->invoke($helper, $playerVars));
        $this->assertContains('foo3', $method->invoke($helper, $playerVars));
        $this->assertContains('1', $method->invoke($helper, $playerVars));

        $this->assertNotContains('foo2', $method->invoke($helper, $playerVars));
        $this->assertNotContains('null', $method->invoke($helper, $playerVars));
    }
}
