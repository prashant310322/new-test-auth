<?php


namespace App\Tests\Service;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

    public function  testSomething()
    {
        self::bootKernel();

        $container = static ::getContainer();


        $checkUserService = $container->get(UserService::class);

        $checkUser = $checkUserService->findUserById(1);

        $count = 1;
        if (empty($checkUser))
        {
            $count = 0;
        }

        $this->assertEquals(1, $count);

    }


}