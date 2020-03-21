<?php
/**
 * User: Venus
 * Date: 21/03/2020
 * Time: 17:13
 */

namespace App\Controller;

use App\Repository\AppUserRepository;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends ApiController
{
    /**
     * @Route("/users")
     */
    public function usersAction(AppUserRepository $userRepository)
    {
        $users = $userRepository->transformAll();

        return $this->respond($users);
    }
}
