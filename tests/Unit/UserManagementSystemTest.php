<?php

namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Session;

class UserManagementSystemTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */


    /**  @test */
    public function user_can_login()
    {

        $user  = factory(\App\User::class)->create();
        Session::start();
        $response = $this->followingRedirects()->post('/login', [
        'email' => $user->email,
        'password' => '123456',
        '_token' => csrf_token()
    ]);

        $this->assertEquals(200, $response->getStatusCode());
        $response->assertSeeText($user->name);
    }


    /**  @test */
    public function admin_can_add_users()
    {

        $user  = factory(\App\User::class)->make();
        Session::start();
        $response = $this->actingAs($user)->followingRedirects()->post('/users', [
            'email' => $user->email,
            'password' => '123456',
            'name' => $user->name ,
            'rule' => 1,
            '_token' => csrf_token()
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);
    }


    /**  @test */
    public function users_must_have_admin_role_to_be_able_to_add_users()
    {
        $user  = factory(\App\User::class)->make(["is_admin" => 0]);
        $this->be($user);
        Session::start();
        $response = $this->actingAs($user)->followingRedirects()->post('/users', [
            'email' => $user->email,
            'password' => '123456',
            'is_admin' => 1,
            'name' => $user->name ,
            '_token' => csrf_token()
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $user->email
        ]);

    }

    /**
     * it's better to make theses tests as feature tests not unit
     * and each feature to be in its own file with readable name
     */

    /** @test */
    public function admin_can_remove_users(){
            
            $this->assertTrue(true);
            /** @todo */
    }
    
    /** @test */
    public function admin_can_edit_users(){
            
            $this->assertTrue(true);
            /** @todo */
    }



}