<?php

namespace App\Tests\Entity;

use App\Entity\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    private $item;

    protected function setUp(): void
    {
        parent::setUp();

        $today = new DateTime('now');
        $createdItemAt = $today->add(new DateInterval('PT45M'));

        $this->item = new Item('Mon super test',"Mon super Test qui me donnera une bonne note car si j'ai pas une bonne note je serai à la rue.",$createdItemAt);
    }

    public function testIsValidNominal()
    {
        $this->assertTrue($this->item->isValid());
    }

    public function testIsNameEmpty()
    {
        $this->item->setName('');
        $this->assertFalse($this->item->isValid());
    }

    public function testIsContentEmpty()
    {
        $this->item->setContent('');
        $this->assertFalse($this->item->isValid());
    }

    public function testIsLengthContent()
    {
        $this->item->setContent('ef');
        $this->assertTrue($this->item->isValid());
    }

    public function testIsDateEmpty()
    {
        $this->item->setCreatedAt('');
        $this->assertFalse($this->item->isValid());
    }
}
