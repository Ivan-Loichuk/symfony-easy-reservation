<?php
/**
 * User: Venus
 * Date: 21/03/2020
 * Time: 17:13
 */

namespace App\Controller;

use App\Repository\AppUserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class UserController extends ApiController
{
    /**
     * @Route("/users")
     * @IsGranted("ROLE_ADMIN")
     */
    public function usersAction(AppUserRepository $userRepository)
    {
        $users = $userRepository->transformAll();

        return $this->respond($users);
    }
}
