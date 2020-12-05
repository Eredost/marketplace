<?php


namespace App\Tests\Entity;


use App\Entity\Category;
use App\Entity\Subcategory;
use App\Tests\Entity\Traits\AssertsTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SubcategoryTest extends KernelTestCase
{
    use AssertsTrait;

    protected function getEntity()
    {
        return (new Subcategory())
            ->setName('Pomme')
            ->setCategory(new Category())
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
