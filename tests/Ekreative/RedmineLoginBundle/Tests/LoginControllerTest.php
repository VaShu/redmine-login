<?php
/**
 * Created by mcfedr on 27/06/15 15:28
 */

namespace Ekreative\RedmineLoginBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = $this->createClient();
        $client->request('POST', '/login', [], [], [], json_encode([
            'login' => [
                'username' => $client->getContainer()->getParameter('user_user'),
                'password' => $client->getContainer()->getParameter('user_pass')
            ]
        ]));

        $response = $client->getResponse();
        $this->assertEquals($response->getStatusCode(), 200);

        $data = json_decode($response->getContent(), true);
        $this->assertFalse($data['user']['admin']);
    }

    public function testAdminLogin()
    {
        $client = $this->createClient();
        $client->request('POST', '/login', [], [], [], json_encode([
            'login' => [
                'username' => $client->getContainer()->getParameter('admin_user'),
                'password' => $client->getContainer()->getParameter('admin_pass')
            ]
        ]));

        $response = $client->getResponse();
        $this->assertEquals($response->getStatusCode(), 200);

        $data = json_decode($response->getContent(), true);
        $this->assertTrue($data['user']['admin']);
    }
}
