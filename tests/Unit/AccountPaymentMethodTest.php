<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\AccountGroup;
use App\Models\AccountPaymentMethod;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\Unit\Traits\Authenticate;

class AccountPaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    use Authenticate;

    private function createTestData(): array
    {
        $accountGroup = AccountGroup::factory()->createOne();
        $account = Account::factory()->create(['account_group_id' => $accountGroup->id]);
        $paymentMethod = PaymentMethod::factory()->createOne();

        return [
            'account' => $account,
            'paymentMethod' => $paymentMethod
        ];
    }

    private function createAccountPaymentMethodTestData(): AccountPaymentMethod
    {
        $data = $this->createTestData();
        return AccountPaymentMethod::factory()->createOne([
            'account_id' => $data['account']->id,
            'payment_method_id' => $data['paymentMethod']->id
        ]);
    }

    public function test_account_payment_method_storing()
    {

        $data = $this->createTestData();

        $response = $this->withToken($this->authenticate())->postJson('api/account_payment_method', [
            'title' => fake()->title(),
            'payment_method_id' => $data['paymentMethod']->id,
            'account_id' => $data['account']->id,
            'remark' => fake()->text(100),
            'is_active' => fake()->boolean(80),
        ]);

        $response->assertStatus(201);
        $this->assertArrayHasKey('data', $response->json());
    }

    public function test_account_payment_method_storing_without_is_active()
    {

        $data = $this->createTestData();

        $response = $this->withToken($this->authenticate())->postJson('api/account_payment_method', [
            'title' => fake()->title(),
            'payment_method_id' => $data['paymentMethod']->id,
            'account_id' => $data['account']->id,
            'remark' => fake()->text(100)
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('account_payment_methods', [
            'is_active' => true,
        ]);

        $this->assertArrayHasKey('data',$response->json());

    }

    public function test_account_payment_method_with_empty_title()
    {

        $data = $this->createTestData();

        $response = $this->withToken($this->authenticate())->postJson('api/account_payment_method', [
            'title' => '',
            'payment_method_id' => $data['paymentMethod']->id,
            'account_id' => $data['account']->id,
            'remark' => fake()->text(100)
        ]);

        $response->assertStatus(422);
        $response->assertUnprocessable()->assertJsonValidationErrors('title');

    }

    public function test_account_payment_method_with_non_existing_payment_method_id()
    {

        $data = $this->createTestData();

        $response = $this->withToken($this->authenticate())->postJson('api/account_payment_method', [
            'title' =>  fake()->title(),
            'payment_method_id' => PHP_INT_MAX,
            'account_id' => $data['account']->id,
            'remark' => fake()->text(100)
        ]);

        $response->assertStatus(422);
        $response->assertUnprocessable()->assertJsonValidationErrors('payment_method_id');

    }

    public function test_account_payment_method_with_non_existing_account_id()
    {

        $data = $this->createTestData();

        $response = $this->withToken($this->authenticate())->postJson('api/account_payment_method', [
            'title' =>  fake()->title(),
            'payment_method_id' => $data['paymentMethod']->id,
            'account_id' => PHP_INT_MAX,
            'remark' => fake()->text(100)
        ]);

        $response->assertStatus(422);
        $response->assertUnprocessable()->assertJsonValidationErrors('account_id');

    }

    public function test_account_payment_method_with_empty_remark()
    {

        $data = $this->createTestData();

        $response = $this->withToken($this->authenticate())->postJson('api/account_payment_method', [
            'title' =>  fake()->title(),
            'payment_method_id' => $data['paymentMethod']->id,
            'account_id' => $data['account']->id,
            'remark' => ''
        ]);

        $response->assertStatus(422);
        $response->assertUnprocessable()->assertJsonValidationErrors('remark');

    }

    public function test_account_payment_method_by_id()
    {

        $accountPaymentGroup = $this->createAccountPaymentMethodTestData();

        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson("api/account_payment_method/{$accountPaymentGroup->id}");

        $response->assertOk();

        $this->assertArrayHasKey('data', $response->json());

    }

    public function test_account_payment_method_by_id_not_found()
    {
        $id = PHP_INT_MAX;
        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson("api/account_payment_method/{$id}");

        $response->assertNotFound();
    }

    public function test_account_payment_method_listing()
    {
        $accountPaymentGroup = $this->createAccountPaymentMethodTestData();

        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson("api/account_payment_method?[filters][id]={$accountPaymentGroup->id}");

        $response->assertOk();

        $this->assertArrayHasKey('data', $response->json());

        $this->assertCount(1, $response->json()['data']);
    }

    public function test_account_payment_method_update()
    {

        $accountPaymentGroup = $this->createAccountPaymentMethodTestData();

        $updatedTitle = fake()->title();

        while($updatedTitle == $accountPaymentGroup->title){
            $updatedTitle = fake()->title();
        }

        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->putJson("api/account_payment_method/{$accountPaymentGroup->id}", [
                'title' => $updatedTitle,
                'payment_method_id' => $accountPaymentGroup->payment_method_id,
                'account_id' => $accountPaymentGroup->account_id,
                'remark' => $accountPaymentGroup->remark,
                'is_active' => $accountPaymentGroup->is_active
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('account_payment_methods', [
            'title' => $updatedTitle,
            'payment_method_id' => $accountPaymentGroup->payment_method_id,
            'account_id' => $accountPaymentGroup->account_id,
            'remark' => $accountPaymentGroup->remark,
            'is_active' => $accountPaymentGroup->is_active
        ]);

        $this->assertArrayHasKey('data', $response->json());
    }

    public function test_account_payment_method_delete()
    {
        $accountPaymentGroup = $this->createAccountPaymentMethodTestData();

        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->deleteJson("api/account_payment_method/{$accountPaymentGroup->id}");

        $response->assertNoContent();

        $this->assertNull(AccountPaymentMethod::find($accountPaymentGroup->id));

    }

    public function test_account_payment_method_delete_not_found()
    {
        $accountPaymentGroup = $this->createAccountPaymentMethodTestData();

        $deletedId = $accountPaymentGroup->id;
        $accountPaymentGroup->delete();

        $response = $this->withToken($this->authenticate())->getJson("api/account_payment_method/{$deletedId}");

        $response->assertNotFound();

    }


}