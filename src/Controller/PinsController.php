<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
   private $em;

   public function __construct(EntityManagerInterface $em)
   {
       $this->em = $em;
   }

    /**
     * @Route("/pins/create", name="app_pins_create", methods={"GET", "POST"})
     * @return void
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            if ($this->isCsrfTokenValid('pins_create', $data['_token'])) {
                $pin = new Pin();
                $pin->setTitle($data['title']);
                $pin->setDescription(($data['description']));
                
                $em->persist($pin);
                $em->flush();
            }
            return $this->redirectToRoute('app_home');
        }
        return $this->render('pins/create.html.twig');
    }

    /**
     * @Route("/", name="app_home")
     * @return response
     */
    public function index(PinRepository $repo): response
    {   //$pin = new Pin();
        //$pin->setTitle('Titre 9');
        //$pin->setDescription('Description 9');
        //$this->em->persist($pin);
        //$em->flush();
        return $this->render('pins/index.html.twig', ['pins' => $repo->findAll()]);
    }

    /**
     * @Route("/pins/{id}", name="app_pin_show")
     *
     * @return Response
     */
    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig', [
            'pin' => $pin
        ]);
    }

   
}