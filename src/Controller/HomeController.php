<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Form\ContactType;
use App\Repository\ChampionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    /*
    public function allChamp(): Response
    {
        $json = file_get_contents('https://ddragon.leagueoflegends.com/cdn/12.4.1/data/fr_FR/championFull.json');
        $decode = json_decode($json, true);
        $allChamp = $decode['data'];
        return $this->render('all/allChamp.html.twig', [
            'testAll' => $allChamp
        ]);
    }*/

    /**
     * @Route("/contact", name="contact", methods={"GET"})
     */
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Voir projet piscine, prendre mailer pas swift
        }

        return $this->render('contact/contact.html.twig', [
            'devisForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/tips", name="tips", methods={"GET"})
     */
    public function tips(): Response
    {
        return $this->render('yone/tips.html.twig');
    }

    /**
     * @Route("/{champion}", name="showChamp", methods={"GET"})
     */
    public function showChamp(string $champion, ManagerRegistry $managerRegistry): Response
    {

        $result = $managerRegistry->getRepository(Champion::class)->findOneBy(['id' => $champion]);

        $json = file_get_contents('https://ddragon.leagueoflegends.com/cdn/12.4.1/data/fr_FR/championFull.json');
        $decode = json_decode($json);
        if (!$result){
            return $this->render('bundles/TwigBundle/Exception/error500.html.twig');
        }
        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $result->getName());

        if($name == "Wukong"){
            $info = $decode->{'data'}->{'MonkeyKing'};
        } else if ($name == "VelKoz"){
            $info = $decode->{'data'}->{ucfirst(strtolower($name))};
        } else {
            $info = $decode->{'data'}->{$name};
        }

        return $this->render('yone/champSelect.html.twig', [
            'champion' => $result,
            'info' => $info,
        ]);
    }

}
