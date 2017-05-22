<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/19
 * Time: 01:20
 *
 * @author limi
 */

namespace Tests\Bati\Transform;

use Tests\Bati\TestCase;
use Zeroleaf\Bati\Transform\Transformer;

/**
 * Class ManagerTest
 *
 * @package Zeroleaf\Bati\Transform
 */
class ManagerTest extends TestCase
{
    /**
     * @var Transformer
     */
    protected $manager;

    /**
     * 
     */
    protected function setUp()
    {
        parent::setUp();

        $this->manager = new Transformer();
    }

    /**
     * 属性测试.
     */
    public function testTransformProperty()
    {
        $this->assertNotEmpty($this->manager->transform("{text}"));

        $this->assertRegExp('/\d{11}/', $this->manager->transform("{phoneNumber}"));
    }

    /**
     * 1 个参数的函数测试.
     */
    public function testTransformOneArgMethod()
    {
        $this->assertNotEmpty($text = $this->manager->transform("{text(12)}"));
        $this->assertLessThanOrEqual(12, strlen($text));

        $this->assertNotEmpty($text = $this->manager->transform("{numerify('Hello ###')}"));
        $this->assertRegExp('/^Hello \d{3}$/', $text);
    }

    /**
     * 2 个参数的函数测试.
     */
    public function testTwoArgsMethod()
    {
        $number = $this->manager->transform('{numberBetween(1000, 9999)}');
        $this->assertGreaterThanOrEqual(1000, $number);
        $this->assertLessThanOrEqual(9999, $number);
    }
}
