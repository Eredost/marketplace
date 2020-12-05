<?php


namespace App\Tests\Entity;

use App\Entity\User;
use App\Tests\Entity\Traits\AssertsTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    use AssertsTrait;

    public function getEntity()
    {
        return (new User())
            ->setEmail('usertest@email.com')
            ->setPassword('$2y$10$rpJS6a4YsQCo7juJVO7wRejtkot7BXJzSr33XhxEwp28DbFiBqtXu')
            ->setFirstname('John')
            ->setLastname('Doe')
            ->setTelephone('0600000000')
            ->setAddress('55 rue Bernard Villepin')
            ->setPostalCode('62500')
            ->setCity('AlfortVille')
            ->setCreatedAt(new \DateTime())
        ;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity());
    }

    public function testInvalidBlankEmail()
    {
        $entity = $this->getEntity()
            ->setEmail('')
        ;
        $this->assertHasErrors($entity, 2);
    }

    public function testInvalidLengthEmail()
    {
        $entity = $this->getEntity()
            ->setEmail('e@a.l')
        ;
        $this->assertHasErrors($entity, 1);

        $entity->setEmail(str_repeat('h', 180) . '@email.com');
        $this->assertHasErrors($entity, 1);
    }

    public function testInvalidFormatEmail()
    {
        $entity = $this->getEntity()
            ->setEmail('hello@email.')
        ;
        $this->assertHasErrors($entity, 1);
    }

    public function testInvalidUniqueEmail()
    {
        $entity = $this->getEntity()
            ->setEmail('user@email.com')
        ;
        $this->assertHasErrors($entity, 1);
    }

    public function testInvalidBlankPassword()
    {
        $entity = $this->getEntity()
            ->setPassword('')
        ;
        $this->assertHasErrors($entity, 1);
    }

    public function testValidBlankFirstname()
    {
        $entity = $this->getEntity()
            ->setFirstname('')
        ;
        $this->assertHasErrors($entity);
    }

    public function testInvalidLengthFirstname()
    {
        $entity = $this->getEntity()
            ->setFirstname('a')
        ;
        $this->assertHasErrors($entity, 1);

        $entity->setFirstname(str_repeat('a', 22));
        $this->assertHasErrors($entity, 1);
    }

    public function testValidBlankLastname()
    {
        $entity = $this->getEntity()
            ->setLastname('')
        ;
        $this->assertHasErrors($entity);
    }

    public function testInvalidValueTelephone()
    {
        $this->assertHasErrors($this->getEntity()->setTelephone('06203040'), 1);
    }

    public function testValidFormatTelephone()
    {
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setTelephone('0123456789'));
        $this->assertHasErrors($entity->setTelephone('01 23 45 67 89'));
        $this->assertHasErrors($entity->setTelephone('01.23.45.67.89'));
    }

    public function testValidBlankAddress()
    {
        $entity = $this->getEntity()
            ->setAddress('')
        ;
        $this->assertHasErrors($entity);
    }

    public function testInvalidLengthAddress()
    {
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setAddress('a'), 1);
        $this->assertHasErrors($entity->setAddress(str_repeat('a', 65)), 1);
    }

    public function testValidBlankPostalCode()
    {
        $entity = $this->getEntity()
            ->setPostalCode(null)
        ;
        $this->assertHasErrors($entity);
    }

    public function testInvalidLengthPostalCode()
    {
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setPostalCode(1), 1);
        $this->assertHasErrors($entity->setPostalCode(627843), 1);
    }

    public function testValidBlankCity()
    {
        $entity = $this->getEntity()
            ->setCity('')
        ;
        $this->assertHasErrors($entity);
    }

    public function testInvalidLengthCity()
    {
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setCity('a'), 1);
        $this->assertHasErrors($entity->setCity(str_repeat('a', 51)), 1);
    }
}
