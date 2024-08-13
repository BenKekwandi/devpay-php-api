<?php 

namespace Tests\Unit ;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\Unit\Model\CreateUserModel;
/** Traits */
use Tests\Unit\Traits\CreateUser;


class AuthTest extends TestCase{

    use RefreshDatabase;
    use CreateUser;

    public function test_successful_login()
    {

        $user = $this->createUser(new CreateUserModel());
       
        $response = $this->postJson('api/login', [
            "username"=> $user->username,
            "password"=> "password"
        ]);

        $response->assertStatus(200)->assertOk();

        $this->assertArrayHasKey('token',$response->json());

    }

    public function test_attempt_login_wrong_password()
    {
        $response = $this->postJson('api/login', [ 
            "username"=> "shaktar@donetsk.com", 
            "password"=>"pas@2e32Ad" 
        ]);

        $response->assertUnauthorized();
    }

    public function test_attempt_login_with_invalid_username()
    {
        $response = $this->postJson('api/login', [
            "username"=>"aa",
            "password"=>"password"
        ]);

        $response->assertUnprocessable();

        $this->assertArrayHasKey('errors',$response->json());
    }

    public function test_attempt_login_with_wrong_password()
    {


        $user = $this->createUser(new CreateUserModel());

        $response = $this->postJson('api/login', [
            "username"=>$user->username,
            "password"=>"0"
        ]);

        $response->assertUnprocessable();

        $this->assertArrayHasKey('errors',$response->json());

    }

    public function test_attempt_login_with_inactive_user()
    {

        $createUserModel = new CreateUserModel();
        $createUserModel->isUserActive = false;

        $user = $this->createUser($createUserModel);

        $response = $this->postJson('api/login', [
            "username"=> $user->username,
            "password"=>"password"
        ]);

        $response->assertForbidden();

    }

    public function test_attempt_login_with_inactive_account()
    {
        $createUserModel = new CreateUserModel();
        $createUserModel->isAccountActive = false;

        $user = $this->createUser($createUserModel);

        $response = $this->postJson('api/login', [
            "username"=> $user->username,
            "password"=>"password"
        ]);

        $response->assertForbidden();
    }

    public function test_attempt_login_with_inactive_account_group()
    {

        $createUserModel = new CreateUserModel();
        $createUserModel->isAccountGroupActive = false;

        $user = $this->createUser($createUserModel);

        $response = $this->postJson('api/login', [
            "username"=>$user->username,
            "password"=>"password"
        ]);

        $response->assertForbidden();
    }

}
