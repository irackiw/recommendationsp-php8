<?php

namespace App\Command;

use App\Entity\Film;
use App\Entity\Rate;
use App\Entity\User;
use App\Repository\FilmRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportRatesCommand extends Command
{
    protected static $defaultName = 'rate:import-csv';

    private EntityManagerInterface $enityManager;

    /** @var FilmRepository */
    private EntityRepository $filmRepository;

    public function __construct(string $name = null, EntityManagerInterface $entityManager)
    {
        parent::__construct($name);
        $this->enityManager = $entityManager;
        $this->filmRepository = $entityManager->getRepository(Film::class);
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rowNo = 1;
        if (($fp = fopen("/var/www/html/public/files/sample.csv", "r")) !== false) {
            while (($row = fgetcsv($fp, 1000, ";")) !== false) {
                $num = count($row);
                $rowNo++;
                $name = $row[0];
                if (!is_string($name) && strlen($name) == 0) {
                    continue;
                }
                $user = new User($name);
                for ($c = 0; $c < $num; $c++) {

                    if (is_string($row[$c]) && strlen($row[$c]) > 0 && (key_exists($c + 1, $row) && is_numeric(
                                $row[$c + 1]
                            ) && $row[$c + 1] > 0) && ($c % 2) == 1) {
                        print_r('User: '.$name.' Film: '.$row[$c].' Ocena: '.$row[$c + 1]."\n");
                        $film = $this->filmRepository->getOrCreate($row[$c]);
                        $rate = new Rate((int)$row[$c + 1], $film, $user);
                        $this->enityManager->persist($rate);
                        $this->enityManager->flush();
                    }
                }
            }
            fclose($fp);
        }

        return Command::SUCCESS;
    }
}
