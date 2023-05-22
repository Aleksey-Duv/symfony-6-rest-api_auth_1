<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
//dd($data);
        $email_exist = $this->user->findOneBy($email);

        if ($email_exist) {
//            return $this->json('',200);
            return new JsonResponse
            (
                [
                    'statys' => false,
                    'message' => 'проверка '
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
                    'message'=>'tru'
                ]
            );

        }

//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/UserController.php',
//        ]);
    }
}
