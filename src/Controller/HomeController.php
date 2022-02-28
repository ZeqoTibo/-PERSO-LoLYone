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
     * @Route("/{champion}", name="showChamp", methods={"GET"})
     */
    public function showChamp (string $champion, ManagerRegistry $managerRegistry): Response
    {
        $result = $managerRegistry->getRepository(Champion::class)->findOneBy(['id'=>$champion]);
        return $this->render('yone/champSelect.html.twig', [
            'champion' => $result,
        ]);
    }

}
