<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    public function __construct()
    {
        $year = 2000;
        $month = 4;
        $day = 19;
        $hour = 20;
        $minute = 30;
        $second = 15;
        $tz = 'Europe/Madrid';
        $this->user = new User();
        $this->user->setFirstname("Yassine");
        $this->user->setLastname("Bousaidi");
        $this->user->setBirthday(Carbon::createFromDate($year, $month, $day, $tz));

    }

    public function testIsValidNominal()
    {
        echo $this->user->getEmail();
        $this->assertTrue($this->user->isValid());
    }

    public function testIsValidEmailBadFormat()
    {
        $this->user->setEmail("fausseEmail");
        $this->assertFalse($this->user->isValid());
    }

    public function testIsBirthdayValid()
    {
        $year = 2000;
        $month = 4;
        $day = 19;
        $tz = 'Europe/Paris';
        $this->user->setBirthday(Carbon::createFromDate($year, $month, $day, $tz));
        $this->assertTrue($this->user->isValid());

    }

    public function testIsFirstNameEmpty()
    {
        $this->user->getFirstname('');
        $this->assertTrue($this->user->isValid());
    }

    public function testIsNotPasswordSizeValid()
    {
        $this->user->setPassword('abc');
        $this->assertFalse($this->user->isValid());
    }

    public function testIsNotPasswordEmptyValid()
    {
        $this->user->setPassword('');
        $this->assertFalse($this->user->isValid());
    }
}
