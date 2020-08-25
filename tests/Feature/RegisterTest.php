<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    public function testNameFailed()
    {
        $faker = Factory::create();
        $datas = [
            'document' => '634.489.640-00',
            'email' => $faker->safeEmail,
            'password' => bcrypt(str_random(10))
        ];
        $response = $this->post('/api/user/register', $datas);
        $response->assertStatus(406);
    }

    public function testDocumentFailed()
    {
        $faker = Factory::create();
        $datas = [
            'name' => $faker->name,
            'email' => $faker->safeEmail,
            'password' => bcrypt(str_random(10))
        ];
        $response = $this->post('/api/user/register', $datas);
        $response->assertStatus(406);
    }

    public function testEmailFailed()
    {
        $faker = Factory::create();
        $datas = [
            'name' => $faker->name,
            'document' => '634.489.640-00',
            'password' => bcrypt(str_random(10))
        ];
        $response = $this->post('/api/user/register', $datas);
        $response->assertStatus(406);
    }

    public function testPasswordFailed()
    {
        $faker = Factory::create();
        $datas = [
            'name' => $faker->name,
            'document' => '634.489.640-00',
            'email' => $faker->safeEmail
        ];
        $response = $this->post('/api/user/register', $datas);
        $response->assertStatus(406);
    }

    public function testRegisterClient()
    {
        $faker = Factory::create();
        $datas = [
            'name' => $faker->name,
            'document' => '634.489.640-00',
            'email' => $faker->safeEmail,
            'password' => bcrypt(str_random(10))
        ];
        $response = $this->post('/api/user/register', $datas);
        $response->assertStatus(200);
    }

    public function testRegisterStore()
    {
        $faker = Factory::create();
        $datas = [
            'name' => $faker->name,
            'document' => '99.576.734/0001-80',
            'email' => $faker->safeEmail,
            'password' => bcrypt(str_random(10))
        ];
        $response = $this->post('/api/user/register', $datas);
        $response->assertStatus(200);
    }

}