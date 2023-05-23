<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function MongoDB\BSON\toJSON;

class UserController extends AbstractController
{
    private $user;
    private $manager;

    public function __construct(entityManagerInterface $manager, UserRepository $user)
    {
        $this->manager = $manager;
        $this->user = $user;

    }

//    #[Route('/user', name: 'app_user')]
    #[Route('/userCreate', name: 'user_create', methods: 'POST')]
    public function userCreate(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $password = $data['password'];
//dd($data );
        $email_exist = $this->user->findOneByEmail($email);
//dd($email_exist);
        if ($email_exist) {
//            return $this->json('',200);
            return new JsonResponse
            (
                [
                    'statys' => false,
                    'message' => 'mail already exists'
                ]
            );
        } else {
            $user = new User();
            $user->setEmail($email)
                ->setPassword(sha1($password));

            $this->manager->persist($user);
            $this->manager->flush();
            return new JsonResponse
            (
                [
                    'statys'=>true,
                    'message'=>'user added'
                ]
            );

        }

//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/UserController.php',
//        ]);
    }

//    #[Route('/userCreate', name: 'user_create', methods: 'POST')]
//    public function userCreate(Request $request): JsonResponse
//    {
//       return 'dd';
//    }


    #[Route('/getAllUser', name: 'get_allures', methods: 'GET')]
    public function getAllUser(entityManagerInterface $manager): JsonResponse
    {
        $users=$this->user->findAll();

        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'description' => $user->getRoles(),
                'password' => $user->getPassword(),
            ];
        }

        $response = new JsonResponse($data);

        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

}
