<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function PHPUnit\Framework\isNull;

#[Route("/api")]
class LoginController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ["POST"])]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $data = json_decode($request->getContent());
        $user = $userRepository->findOneBy(["email" => $data->email]);

        if (is_null($user)) {
            throw new BadRequestHttpException("User does not exist");
        } else {
            if (password_verify($data->password, $user->getPassword())) {
                return $this->json(["message" => "Authentication successful"]);
            } else {
                throw new BadRequestHttpException("Incorrect password");
            }
        }
    }
}
    //#[Route('/logout', name: 'logout')]
    //public function logout(){}
//}