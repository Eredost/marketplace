<?php


namespace App\Tests\Entity;


use App\Entity\Producer;
use App\Entity\Product;
use App\Entity\Subcategory;
use App\Tests\Entity\Traits\AssertsTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductTest extends KernelTestCase
{
    use AssertsTrait;

    protected function getEntity()
    {
        return (new Product())
            ->setName('tomate')
            ->setPrice(5.20)
            ->setWeight(1000)
            ->setQuantity(29)
            ->setProducer(new Producer())
            ->addSubcategory(new Subcategory())
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
        $product = $this->getEntity();
        $this->assertHasErrors($product->setName('l'), 1);
        $this->assertHasErrors($product->setName(str_repeat('l', 65)), 1);
    }

    public function testInvalidNegativeWeight()
    {
        $this->assertHasErrors($this->getEntity()->setWeight(-2), 1);
    }

    public function testInvalidNegativeQuantity()
    {
        $this->assertHasErrors($this->getEntity()->setQuantity(-5), 1);
    }

    public function testInvalidLengthDescription()
    {
        $this->assertHasErrors($this->getEntity()->setDescription(str_repeat('l', 801)), 1);
    }

    public function testInvalidLengthComposition()
    {
        $this->assertHasErrors($this->getEntity()->setComposition(str_repeat('l', 401)), 1);
    }

    public function testInvalidLengthAdditionalInfo()
    {
        $this->assertHasErrors($this->getEntity()->setAdditionalInfo(str_repeat('l', 401)), 1);
    }

    public function testInvalidLengthAllergens()
    {
        $this->assertHasErrors($this->getEntity()->setAllergens(str_repeat('l', 401)), 1);
    }

    public function testInvalidNegativeRate()
    {
        $this->assertHasErrors($this->getEntity()->setRate(-5), 1);
    }
}
