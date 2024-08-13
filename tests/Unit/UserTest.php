<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Enums\UserTypeEnum;
use Tests\Unit\Model\CreateUserModel;
use Hash;


/**
 * Traits
 */
use Tests\Unit\Traits\Authenticate;

class UserTest extends TestCase
{

    use RefreshDatabase;
    use Authenticate;

    public function test_user_storing(): void
    {
        $response = $this->withToken($this->authenticate())->withHeaders(['Accept' => 'application/json'])->postJson('api/user', [
            'name' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->email,
            'username' => uniqid(),
            'password' => fake()->password(),
            'type' => UserTypeEnum::MASTER,
            'is_active' => true
        ]);

        $response->assertStatus(201);
        $this->assertArrayHasKey('data', $response->json());
    }

    public function test_user_storing_without_is_active(): void
    {

        $response = $this->withToken($this->authenticate())->postJson('api/user', [
            'name' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->email,
            'username' => uniqid(),
            'password' => fake()->password(),
            'type' => UserTypeEnum::MASTER,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'is_active' => true,
        ]);

        $this->assertArrayHasKey('data', $response->json());
    }

    public function test_user_validation_with_short_username(): void
    {
        $response = $this->withToken($this->authenticate())->postJson('api/user', [
            'name' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->email,
            'username' => 'test',
            'password' => fake()->password(),
            'type' => UserTypeEnum::MASTER,
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors('username');
    }

    public function test_user_validation_with_short_password()
    {
        $response = $this->withToken($this->authenticate())->postJson('api/user', [
            'name' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->email,
            'username' => uniqid(),
            'password' => '123',
            'type' => UserTypeEnum::MASTER,
        ]);
        $response->assertUnprocessable()->assertJsonValidationErrors('password');
    }

    public function test_user_validation_with_unwanted_characters_username()
    {

        $auth = $this->authenticate();

        $response1 = $this->withToken($auth)->postJson('api/user', [
            'name' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->email,
            'username' => 'user name',
            'password' => fake()->password(),
            'type' => UserTypeEnum::MASTER,
        ]);
        $response1->assertUnprocessable()->assertJsonValidationErrors('username');

        $response2 = $this->withToken($auth)->postJson('api/user', [
            'name' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->email,
            'username' => 'username@',
            'password' => fake()->password(),
            'type' => UserTypeEnum::MASTER,
        ]);
        $response2->assertUnprocessable()->assertJsonValidationErrors('username');

        $response3 = $this->withToken($auth)->postJson('api/user', [
            'name' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->email,
            'username' => 'username"',
            'password' => fake()->password(),
            'type' => UserTypeEnum::MASTER,
        ]);
        $response3->assertUnprocessable()->assertJsonValidationErrors('username');

    }

    public function test_user_validation_with_already_taken_username()
    {
        $createUserModer = new CreateUserModel();
        $createUserModer->accountBinding = false;
        $user = $this->createUser($createUserModer);

        $response = $this->withToken($this->authenticate())->postJson('api/user', [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->email,
            'lastname' => fake()->lastName(),
            'username' => $user->username,
            'password' => fake()->password(),
            'type' => UserTypeEnum::MASTER,
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors('username');

    }


    public function test_user_validation_with_incorrect_user_type()
    {
        $response = $this->withToken($this->authenticate())->postJson('api/user', [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->email,
            'lastname' => fake()->lastName(),
            'username' => uniqid(),
            'password' => fake()->password(),
            'type' => 'random',
        ]);
        $response->assertUnprocessable()->assertJsonValidationErrors('type');
    }

    public function test_user_validation_with_incorrect_account_id()
    {
        $response = $this->withToken($this->authenticate())->postJson('api/user', [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->email,
            'lastname' => fake()->lastName(),
            'username' => uniqid(),
            'password' => fake()->password(),
            'account_id' => PHP_INT_MAX,
            'type' => UserTypeEnum::ACCOUNT,
        ]);
        $response->assertUnprocessable()->assertJsonValidationErrors('account_id');
    }

    public function test_user_validation_without_name()
    {
        $userRequest = User::factory()->create(['name' => '']);
        $response = $this->withToken($this->authenticate())->postJson('api/user', [
            'name' => '',
            'email' => fake()->unique()->email,
            'lastname' => fake()->lastName(),
            'username' => uniqid(),
            'password' => fake()->password(),
            'account_id' => PHP_INT_MAX,
            'type' => UserTypeEnum::ACCOUNT,
        ]);
        $response->assertUnprocessable()->assertJsonValidationErrors('name');
    }

    public function test_user_validation_without_lastname()
    {
        $response = $this->withToken($this->authenticate())->postJson('api/user', [
            'name' => fake()->firstName(),
            'lastname' => '',
            'email' => fake()->unique()->email,
            'username' => uniqid(),
            'password' => fake()->password(),
            'account_id' => PHP_INT_MAX,
            'type' => UserTypeEnum::ACCOUNT,
        ]);
        $response->assertUnprocessable()->assertJsonValidationErrors('lastname');
    }

    public function test_user_getting_by_id()
    {

        $createUserModer = new CreateUserModel();
        $createUserModer->accountBinding = false;
        $user = $this->createUser($createUserModer);

        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson("api/user/{$user->id}");

        $response->assertOk();

        $this->assertArrayHasKey('data', $response->json());
    }

    public function test_user_getting_with_non_existing_user_id()
    {

        $nonExistingId = PHP_INT_MAX;

        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson("api/user/{$nonExistingId}");

        $response->assertNotFound();
    }

    public function test_user_data_listing()
    {

        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson("api/user");

        $response->assertOk();
        $this->assertArrayHasKey('data', $response->json());

    }

    public function test_user_update()
    {

        $createUserModer = new CreateUserModel();
        $createUserModer->accountBinding = false;
        $user = $this->createUser($createUserModer);

        $updatedName = fake()->name();

        while ($updatedName == $user->name) {
            $updatedName = fake()->name();
        }

        $response = $this->withToken($this->authenticate())
                 ->withHeaders(['Accept' => 'application/json'])
                 ->putJson("api/user/{$user->id}", [
                     'name' => $updatedName,
                     'account_id' => $user->account_id,
                     'lastname' => $user->lastname,
                     'email' => $user->email,
                     'phone' => $user->phone,
                     'username' => $user->username,
                     'type' => $user->type,
                     'is_active' => $user->is_active
                 ]);

        $response->assertOk();

        $this->assertEquals($updatedName, User::findOrFail($user->id)->name);

        $this->assertArrayHasKey('data', $response->json());
    }

    public function test_user_self_password_update()
    {

        $token = $this->authenticate();
        $user =  auth('sanctum')->user();

        $updatedPassword = fake()->password();

        $response = $this->withToken($token)

            ->withHeaders(['Accept' => 'application/json'])
            ->patchJson("api/user/me/change_password", [
                'repeated_password' => $updatedPassword,
                'password' => $updatedPassword,
            ]);

        $response->assertOk();

        $updatedUser = User::findOrFail($user->id);

        $this->assertTrue(Hash::check($updatedPassword, $updatedUser->password));
    }

    public function test_user_password_update()
    {

        $updatedPassword = fake()->password();
        $token = $this->authenticate();
        $user =  auth('sanctum')->user();

        $response = $this->withToken($token)
            ->withHeaders(['Accept' => 'application/json'])
            ->patchJson("api/user/{$user->id}/change_password", [
                'repeated_password' => $updatedPassword,
                'password' => $updatedPassword,
            ]);
        $response->assertOk();

        $updatedUser = User::findOrFail($user->id);

        $this->assertTrue(Hash::check($updatedPassword, $updatedUser->password));

        $this->assertArrayHasKey('data', $response->json());
    }

    public function test_user_deletion()
    {

        $createUserModer = new CreateUserModel();
        $createUserModer->accountBinding = false;
        $user = $this->createUser($createUserModer);

        $response = $this->withToken($this->authenticate())->deleteJson("api/user/{$user->id}", []);

        $response->assertNoContent();

        $this->assertNull(User::find($user->id));

    }

    public function test_user_getting_user_with_deleted_id()
    {
        $createUserModer = new CreateUserModel();
        $createUserModer->accountBinding = false;
        $user = $this->createUser($createUserModer);

        $deletedId = $user->id;
        $user->delete();

        $response = $this->withToken($this->authenticate())->getJson("api/user/{$deletedId}");

        $response->assertNotFound();
    }

}
