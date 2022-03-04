<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Repository\ChampionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{

    /**
     * @var ManagerRegistry $managerRegistry
     */
    public $managerRegistry;

    function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(ChampionRepository $championRepository): Response
    {
        $allChamps = $championRepository->findAll();

        return $this->render('yone/home.html.twig', [
            'allChamps' => $allChamps,
        ]);
    }

    /**
     * @Route("/allChamp", name="allChamp", methods={"GET"})
     */
    public function allChamp(): Response
    {
        $json = file_get_contents('https://ddragon.leagueoflegends.com/cdn/12.4.1/data/fr_FR/championFull.json');
        $decode = json_decode($json, true);
        $allChamp = $decode['data'];
        return $this->render('all/allChamp.html.twig', [
            'testAll' => $allChamp
        ]);
    }

    /**
     * @Route("/{champion}", name="showChamp", methods={"GET"})
     */
    public function showChamp(string $champion, ManagerRegistry $managerRegistry): Response
    {
        $result = $managerRegistry->getRepository(Champion::class)->findOneBy(['id' => $champion]);

        $json = file_get_contents('https://ddragon.leagueoflegends.com/cdn/12.4.1/data/fr_FR/championFull.json');
        $decode = json_decode($json);
        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $result->getName());
        $info = $decode->{'data'}->{$name};
        return $this->render('yone/champSelect.html.twig', [
            'champion' => $result,
            'info' => $info,
        ]);
    }

}
