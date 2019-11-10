<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixture extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $subcategories = $this->getReferences('main_subcategory');

        foreach ($subcategories as $key => $subcategory) {
            $this->createMany(4, 'main_product_'.$key, function($count) use ($subcategory) {
                $product = new Product();
                $product->setName($this->faker->sentence(2, true))
                    ->setPrice($this->faker->randomFloat(2, 1, 40))
                    ->setWeight($this->faker->randomFloat(3, 1, 5))
                    ->setQuantity($this->faker->numberBetween(0, 50))
                    ->setImage('product-placeholder.jpg')
                    ->addSubcategory($subcategory)
                    ->setProducer($this->getRandomReference('main_producer'))
                ;

                return $product;
            });
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}
