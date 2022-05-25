<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use App\Factory\UserFactory;



    class UserResourceTest extends ApiTestCase
{


//    public function testUpdateUser()
//    {
//        $client = self::createClient();
//        $user = UserFactory::new()->create();
//        $this->logIn($client, $user);
//
//        $client->request('PUT', '/api/users/'.$user->getUuid(), [
//            'json' => [
//                'username' => 'newusername',
//                'roles' => ['ROLE_ADMIN'] // will be ignored
//            ]
//        ]);
//        $this->assertResponseIsSuccessful();
//        $this->assertJsonContains([
//            'username' => 'newusername'
//        ]);
//
//        $user->refresh();
//        $this->assertEquals(['ROLE_USER'], $user->getRoles());
//    }

//    public function testGetUser()
//    {
//        $client = self::createClient();
//        $user = UserFactory::new()->create([
//            'phoneNumber' => '555.123.4567',
//            'username' => 'cheesehead',
//        ]);
//        $authenticatedUser = UserFactory::new()->create();
//        $this->logIn($client, $authenticatedUser);
//
//        $client->request('GET', '/api/users/'.$user->getId());
//        $this->assertResponseStatusCodeSame(200);
//        $this->assertJsonContains([
//            'username' => $user->getUsername(),
//            'isMvp' => true,
//        ]);
//
//        $data = $client->getResponse()->toArray();
//        $this->assertArrayNotHasKey('phoneNumber', $data);
//        $this->assertJsonContains([
//            'isMe' => false,
//        ]);
//
//        // refresh the user & elevate
//        $user->refresh();
//        $user->setRoles(['ROLE_ADMIN']);
//        $user->save();
//        $this->logIn($client, $user);
//
//        $client->request('GET', '/api/users/'.$user->getId());
//        $this->assertJsonContains([
//            'phoneNumber' => '555.123.4567',
//            'isMe' => true,
//        ]);
//    }


    public function testPut(): void
    {
//        $response = static::createClient()->request('POST', '/login', ['json' => [
//            'HTTP_HOST' => 'http://localhost:8000',
//            'email' => 'pf@gmail.com',
//            'password' => '123456',
//        ]]);

        $id = 1; $data = [  "lastName" =>"falnikar1"];
        // Act
        $response = static::createClient()->request('PUT', '/api/users/' . $id, [
            'json' => $data,
        ]);

        //dd($response);
        $this->assertResponseIsSuccessful();
    }


    public function  testLogin():void
    {
        $response = static::createClient()->request('POST', '/login', ['json' => [

            'username' => 'pf@gmail.com',
            'password' => '123456',
        ]]);


        $this->assertResponseIsSuccessful();
    }

}
