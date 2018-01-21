<?php
/**
 * Created by PhpStorm.
 * User: mh
 * Date: 21/01/18
 * Time: 10:47 م
 */

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


    public function testUserCanLogin()
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

    public function testAdminCanAddUsers()
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
    public function testCanNotUserCanAddUsers()
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



}