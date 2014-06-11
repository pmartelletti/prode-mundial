<?php
namespace ProdeMundial\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ProdeMundial\CoreBundle\Entity\Game;
use ProdeMundial\CoreBundle\Entity\TeamsGroup;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Config\FileLocator;

class LoadMatches extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $locator = new FileLocator($this->container->get('kernel')->getBundle('ProdeMundialCoreBundle')->getPath()
            . DIRECTORY_SEPARATOR . "Resources/config/data"
        );
        $fixture = $data = file_get_contents($locator->locate('groups.txt', null, true)); //read the file
        $fixture_lines = explode("\n", $data); //create array separate by new line
        // we parse the lines to search the matches
        $group = null;
        foreach($fixture_lines as $line) {
            // we look for the group
            if (preg_match("/Grupo [A-H]:/", $line)) {
                // if the group already exists, then we persist it
                if ($group instanceof TeamsGroup) {
                    $manager->persist($group);
                }
                // we create the new group
                $group = new TeamsGroup();
                $group->setName(rtrim($line, ':'));
            } else {
                if (!empty($line)) {
                    $matchInfo = explode(" ", preg_replace( '/\s+/', ' ', $line ));
                    // we have a game! add it to the group
                    $game = new Game();
                    $hour = end($matchInfo) == '(UTC-3)' ? (int) $matchInfo['3'] : $matchInfo['3'] + 1;
                    $gameDate = new \DateTime(date('m/d/Y', strtotime(str_replace('/', ' ', $matchInfo[2]))));
                    $gameDate->setTime($hour, 0); $gameDate->setTimezone(new \DateTimeZone('America/Buenos_Aires'));
                    $game->setDate($gameDate);
                    $game->setHomeTeam($this->getReference($matchInfo[4]));
                    $game->setAwayTeam($this->getReference($matchInfo[6]));
                    $game->setVenue(join(' ', array_splice($matchInfo, 7)));
                    $game->setFifaMatchId(str_replace(array( '(', ')' ), '', $matchInfo[0]));

                    // we add the match to the group
                    $group->addGame($game);
                }
            }
        }

        // we persist the last group
        if ($group instanceof TeamsGroup) {
            $manager->persist($group);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}