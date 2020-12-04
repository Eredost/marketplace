<?php


namespace App\Tests\Entity;


use App\Entity\Univers;
use App\Tests\Entity\Traits\AssertsTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UniversTest extends KernelTestCase
{
    use AssertsTrait;

    protected function getEntity()
    {
        return (new Univers())
            ->setName('Fruits et légumes')
        ;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity());
    }

    public function testInvalidBlankName()
    {
        $this->assertHasErrors($this->getEntity()->setName(''), 2);
    }

    public function testInvalidLengthName()
    {
        $univers = $this->getEntity();
        $this->assertHasErrors($univers->setName('l'), 1);
        $this->assertHasErrors($univers->setName(str_repeat('l', 65)), 1);
    }
}
