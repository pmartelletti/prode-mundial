<?php
namespace ProdeMundial\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ProdeMundial\CoreBundle\Entity\Team;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

class LoadTeams extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // this surely could be done more efficiently
        $locator = new FileLocator($this->container->get('kernel')->getBundle('ProdeMundialCoreBundle')->getPath()
            . DIRECTORY_SEPARATOR . "Resources/config/data"
        );
        $teamData = Yaml::parse($locator->locate('teams.yml', null, true));
        foreach($teamData as $data) {
            $team = new Team();
            $team->setName($data['name']);
            $team->setFlag($data['flag']);

            $manager->persist($team);
            $this->addReference($data['flag'], $team);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
           return 1; // the order in which fixtures will be loaded
    }
}