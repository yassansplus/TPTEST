<?php

namespace App\Tests\Entity;

use App\Entity\Item;
use App\Entity\User;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class TodoListTest extends TestCase
{
    private $user;
    private $item;
    private $todolist;

    protected function setUp(): void
    {
        parent::setUp();

        $year = 2000;
        $month = 4;
        $day = 19;
        $tz = 'Europe/Paris';
        $myToday = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $createdItemAt = $myToday->add(new DateInterval('PT45M'));

        $this->user = new User();
        $this->user->setLastname("Bousaidi");
        $this->user->setFirstname("Yassine");
        $this->user->setPassword('12345678');
        $this->user->setEmail('Yassine.bousaidi@bogossIntersideral.fr');
        $this->user->setBirthday(Carbon::createFromDate($year, $month, $day, $tz));


        $this->item = new Item('Mon super test', "Mon super Test qui me donnera une bonne note car si j'ai pas une bonne note je serai à la rue.", $createdItemAt);
        $this->todolist = $this->getMockBuilder(TodoList::class)
            ->onlyMethods(['getSizeTodoList', 'getLastItem', 'sendEmailUser'])
            ->getMock();

        $this->todolist->setUser($this->user);
        $this->todolist->expects($this->any())->method('getLastItem')->willReturn($this->item);
    }

    public function testCanAddItemNominal()
    {
        $this->todolist->expects($this->any())->method('getSizeTodoList')->willReturn('1');

        $canAddItem = $this->todolist->canAddItem($this->item);

        $this->assertNotNull($canAddItem);
        $this->assertEquals('Exercice1 à faire', $canAddItem->getName());
    }

    public function testSendEmailToUser()
    {
        $this->todolist->expects($this->once())->method('getSizeTodoList')->willReturn('8');

        $send = $this->todolist->numberItemAlert();

        $this->assertTrue($send);
    }

    public function testCanAddMaxItem()
    {
        $this->todolist->expects($this->any())->method('getSizeTodoList')->willReturn('10');
        $this->expectException('Exception');
        $this->expectExceptionMessage('La todo list possède beaucoup d\'item');

        $canAddItem = $this->todolist->canAddItem($this->item);

        $this->assertTrue($canAddItem);
    }
}
