<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\UserRepository;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function testSanitazeAttributes()
    {
        $userRepository = new UserRepository(new User);

        $attributes["name"] = "  Teste ";
        $attributes["email"] = "   email@email.com   ";
        $attributes["document"] = "  #$@ 123.456.789-10 ,.";
        $result = $userRepository->sanitaze($attributes);

        $this->assertEquals(array_get($result, "name"), "Teste");
        $this->assertEquals(array_get($result, "email"), "email@email.com");
        $this->assertEquals(array_get($result, "document"), "12345678910");
    }

}
