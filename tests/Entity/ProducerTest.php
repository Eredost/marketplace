<?php


namespace App\Tests\Entity;


use App\Entity\Producer;
use App\Entity\User;
use App\Tests\Entity\Traits\AssertsTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProducerTest extends KernelTestCase
{
    use AssertsTrait;

    protected function getEntity()
    {
        return (new Producer())
            ->setSocialReason('Jeunes agriculteurs de Cambrai')
            ->setSiretNumber('800 301 007 00024')
            ->setAddress('43 rue du commerce')
            ->setPostalCode('59400')
            ->setCity('Cambrai')
            ->setEmail('agriculteurs.cambrai@gmail.com')
            ->setFirstname('Sébastien')
            ->setLastname('Messard')
            ->setTelephone('0600000000')
            ->setEnable(true)
            ->setUser(new User())
        ;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity());
    }

    public function testInvalidBlankSocialReason()
    {
        $this->assertHasErrors($this->getEntity()->setSocialReason(''), 2);
    }

    public function testInvalidLengthSocialReason()
    {
        $producer = $this->getEntity();
        $this->assertHasErrors($producer->setSocialReason('l'), 1);
        $this->assertHasErrors($producer->setSocialReason(str_repeat('l', 65)), 1);
    }

    public function testInvalidBlankSiretNumber()
    {
        $this->assertHasErrors($this->getEntity()->setSiretNumber(''), 2);
    }

    public function testInvalidLengthSiretNumber()
    {
        $producer = $this->getEntity();
        $this->assertHasErrors($producer->setSiretNumber('0'), 1);
        $this->assertHasErrors($producer->setSiretNumber(str_repeat('0', 101)), 1);
    }

    public function testInvalidBlankAddress()
    {
        $this->assertHasErrors($this->getEntity()->setAddress(''), 2);
    }

    public function testInvalidLengthAddress()
    {
        $producer = $this->getEntity();
        $this->assertHasErrors($producer->setAddress('l'), 1);
        $this->assertHasErrors($producer->setAddress(str_repeat('l', 65)), 1);
    }

    public function testInvalidBlankPostalCode()
    {
        $this->assertHasErrors($this->getEntity()->setPostalCode(''), 2);
    }

    public function testInvalidLengthPostalCode()
    {
        $producer = $this->getEntity();
        $this->assertHasErrors($producer->setPostalCode('0'), 1);
        $this->assertHasErrors($producer->setPostalCode('000000'), 1);
    }

    public function testInvalidBlankCity()
    {
        $this->assertHasErrors($this->getEntity()->setCity(''), 1);
    }

    public function testInvalidLengthCity()
    {
        $this->assertHasErrors($this->getEntity()->setCity(str_repeat('l', 91)), 1);
    }

    public function testInvalidBlankEmail()
    {
        $this->assertHasErrors($this->getEntity()->setEmail(''), 2);
    }

    public function testInvalidValueEmail()
    {
        $producer = $this->getEntity();
        $this->assertHasErrors($producer->setEmail('email@domain'), 1);
        $this->assertHasErrors($producer->setEmail('@domain.fr'), 1);
        $this->assertHasErrors($producer->setEmail('email-domain.fr'), 1);
    }

    public function testInvalidLengthEmail()
    {
        $producer = $this->getEntity();
        $this->assertHasErrors($producer->setEmail('l@e.r'), 1);
        $this->assertHasErrors($producer->setEmail(str_repeat('l', 180) . '@e.r'), 1);
    }

    public function testInvalidBlankTelephone()
    {
        $this->assertHasErrors($this->getEntity()->setTelephone(''), 2);
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

    public function testInvalidBlankFirstname()
    {
        $this->assertHasErrors($this->getEntity()->setFirstname(''), 2);
    }

    public function testInvalidLengthFirstname()
    {
        $producer = $this->getEntity();
        $this->assertHasErrors($producer->setFirstname('l'), 1);
        $this->assertHasErrors($producer->setFirstname(str_repeat('l', 21)), 1);
    }

    public function testInvalidBlankLastname()
    {
        $this->assertHasErrors($this->getEntity()->setLastname(''), 2);
    }

    public function testInvalidLengthLastname()
    {
        $producer = $this->getEntity();
        $this->assertHasErrors($producer->setLastname('l'), 1);
        $this->assertHasErrors($producer->setLastname(str_repeat('l', 21)), 1);
    }

    public function testInvalidLengthStatus()
    {
        $producer = $this->getEntity();
        $this->assertHasErrors($producer->setStatus('l'), 1);
        $this->assertHasErrors($producer->setStatus(str_repeat('l', 65)), 1);
    }
}
