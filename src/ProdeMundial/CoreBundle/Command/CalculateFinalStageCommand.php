<?php

namespace ProdeMundial\CoreBundle\Command;


use ProdeMundial\CoreBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class CalculateFinalStageCommand extends ContainerAwareCommand
{
    private $validArguments = array(
        'Octavos de final', 'Cuartos de final', 'Semifinal', 'Partido Final'
    );

    protected function configure()
    {
        $this
            ->setName('prode:calculate:final-stage')
            ->setDescription('Calculate the matches for the given stage')
//            ->addArgument('name', InputArgument::REQUIRED, 'What stage do you want to calculate?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelperSet()->get('question');
        $question = new ChoiceQuestion(
            'Please select the phase you want to calculate',
            $this->validArguments
        );

        $question->setErrorMessage('Phase %s is invalid.');

        $phase = $helper->ask($input, $output, $question);
        $this->parseFinalStageText($phase, $output);


    }

    /**
     * @param OutputInterface $output
     */
    private function parseFinalStageText($phase, $output)
    {
        $locator = new FileLocator($this->getContainer()->get('kernel')->getBundle('ProdeMundialCoreBundle')->getPath()
            . DIRECTORY_SEPARATOR . "Resources/config/data"
        );
        $fixture = $data = file_get_contents($locator->locate('final-stage.txt', null, true)); //read the file
        $fixture_lines = explode("\n", $data); //create array separate by new line
        // we parse the lines to search the matches
        $stage = null;
        foreach($fixture_lines as $line) {
            // we look for the group
            if (preg_match("/$phase:/", $line)) {
                // we only parse the lines if the phase is not set
                $stage = $phase;
            } elseif(is_null($stage)){
                continue;
            } else {
                if(preg_match("/:$/", $line) and !is_null($stage)) return;
                if (!empty($line)) {
                    $matchInfo = explode(" ", preg_replace( '/\s+/', ' ', $line ));
                    $fifaId = str_replace(array( '(', ')' ), '', $matchInfo[0]);
                    $game = $this->getContainer()->get('doctrine.orm.entity_manager')
                        ->getRepository('ProdeMundialCoreBundle:Game')->findOneByFifaMatchId($fifaId);
                    if(!$game) {
                        $game = new Game();
                        $game->setFifaMatchId($fifaId);
                    }
                    $gameDate = new \DateTime(date('m/d/Y', strtotime(str_replace('/', ' ', $matchInfo[2]))));
                    $gameDate->setTime((int)$matchInfo[3], 0);
                    $game->setDate($gameDate);
                    $game->setPhase($stage);
                    $game->setVenue(join(' ', array_splice($matchInfo, 7)));
                    // we need to fetch the teams
                    if (preg_match("/[1-2][A-H]/", $matchInfo[4])) {
                        // we need to find the position of the team in the groups
                        $game->setHomeTeam(
                            $this->getContainer()->get('prodemundial.core.groups_handler')->getTeamForFixture($matchInfo[4])
                        );
                        $game->setAwayTeam(
                            $this->getContainer()->get('prodemundial.core.groups_handler')->getTeamForFixture($matchInfo[6])
                        );
                    } else {
                        if (strpos($matchInfo[4], 'W')) {
                            // we look for winning team
                            $match1Id = str_replace('W', '', $matchInfo[4]);
                            $match2Id = str_replace('W', '', $matchInfo[6]);
                            $method = "Winning";
                        } else {
                            // we look for loosing team
                            $match1Id = str_replace('L', '', $matchInfo[4]);
                            $match2Id = str_replace('L', '', $matchInfo[6]);
                            $method = "Loosing";
                        }
                        /** @var Game $game1 */ 
                        $game1 = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('ProdeMundialCoreBundle:Game')
                            ->findOneByFifaMatchId($match1Id);
                        /** @var Game $game2 */
                        $game2 = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('ProdeMundialCoreBundle:Game')
                            ->findOneByFifaMatchId($match2Id);
                        $game->setHomeTeam(call_user_func(array($game1, sprintf('get%sTeam', $method))));
                        $game->setAwayTeam(call_user_func(array($game2, sprintf('get%sTeam', $method))));
                        // we need to find the teams by the winner of the games
                    }
                    $this->getContainer()->get('doctrine.orm.entity_manager')->persist($game);
                    // we save the games
                    $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
                    $this->getContainer()->get('prode.fixtures.creator')->createPredictionsForGame($game);
                }
            }
        }
    }
} 