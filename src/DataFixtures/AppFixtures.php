<?php

namespace App\DataFixtures;

use App\Entity\Champion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Création d'une liste avec les nom de chaque colonne du fichier csv
        $stringsheaders = array("champion" => "Champion",
            "cooldown" => "Cooldowns",
            "difficulty" => "Difficulty",
            "tips" => "Conseils pour les matchs",
            "starting" => "Starting Items",
            "picture" => "Pictures"
        );
        $projectLocation = getcwd(); // Retourne le dossier de travail courant
        $datasDirectory = 'public/fixtures';
        $csvPath = $projectLocation . '/' . $datasDirectory . '/yone.csv';
        $delimiter = ",";
        if (($handle = fopen($csvPath, 'r')) === false) {
            die('Error opening file');
        }
        $headers = fgetcsv($handle, 1024, $delimiter);
        $datas = array();
        while ($row = fgetcsv($handle, 2048, $delimiter)) {
            $datas[] = array_combine($headers, $row);
        }
        fclose($handle);
        foreach ($datas as $data) {
            $this->loadMot($manager,
                $data[$stringsheaders["champion"]],
                $data[$stringsheaders["cooldown"]],
                $data[$stringsheaders["difficulty"]],
                $data[$stringsheaders["starting"]],
                $data[$stringsheaders["tips"]],
                $data[$stringsheaders["picture"]],

            );

        }
        $manager->flush();
    }
    public function loadMot($manager, $name,$cooldown, $difficulty, $starting, $tips, $picture)
    {
        $champ = new Champion();
        $champ->setName($name);
        $champ->setCooldowns($cooldown);
        $champ->setDifficulty((int) $difficulty);
        $champ->setStartingItem($starting);
        $champ->setTips($tips);
        $champ->setPicture(str_replace(' ', '', $picture));
        $manager->persist($champ);
        $manager->flush();
    }

        public function getOrder()
    {
        return 1;
    }
}
