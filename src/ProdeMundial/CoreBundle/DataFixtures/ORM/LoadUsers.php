<?php

namespace ProdeMundial\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $admin = $this->container->get('fos_user.user_manager')->createUser();
        $admin->setUsername('pmartelletti');
        $admin->setEmail('pmartelletti@gmail.com');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->addRole('ROLE_ADMIN');

        $this->container->get('fos_user.user_manager')->updateUser($admin);

        $this->container->get('prode.fixtures.creator')->createPredictionsForUser($admin);
    }

    public function getOrder()
    {
        return 3;
    }

} 