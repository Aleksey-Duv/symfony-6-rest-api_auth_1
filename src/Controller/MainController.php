<?php

namespace App\Controller;

use App\Entity\Prodycts;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MainController.php',
        ]);
    }

    public function setProdyct(PersistenceManagerRegistry $doctrine): Response
    {
        $doctrineManager = $doctrine->getManager();

        $prodyct = new Prodycts();
        $prodyct->setName('Товар5')
                ->setPrise(134);

        $doctrineManager->persist($prodyct);
        $doctrineManager->flush();

        return new Response( 'сохранено' );
    }
    public function getProdyct(PersistenceManagerRegistry $doctrine): Response
    {

        $prodyct = $doctrine->getRepository(Prodycts::class)->findAll();
//        $prodyct = $doctrine->getRepository(Prodycts::class)->find(1);
//        $prod = $prodyct->getName();
//        if (isset($User)) {
//            $name = $User->getUserName() ;
//        }
//dump($User);die;

//        return new Response($name );


//        return new Response( $prod );
        return $this->json($prodyct
//            [
//            'message' => 'test',
//        ]
        );
    }
}
