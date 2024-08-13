<?php

namespace Tests\Unit;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\Unit\Traits\Authenticate;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    use Authenticate;

    public function test_payment_method_storing()
    {

        $response = $this->withToken($this->authenticate())->postJson('api/payment_method', [
            'title' => fake()->title(),
            'is_active' => fake()->boolean(80),
        ]);

        $response->assertStatus(201);
        $this->assertArrayHasKey('data', $response->json());
    }

    public function test_payment_method_storing_without_is_active()
    {
        $response = $this->withToken($this->authenticate())->postJson('api/payment_method', [
            'title' => fake()->title(),
            'is_active' => fake()->boolean(80),
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'is_active' => true,
        ]);

        $this->assertArrayHasKey('data',$response->json());

    }

    public function test_payment_method_with_empty_title()
    {
        $response = $this->withToken($this->authenticate())->postJson('api/payment_method', [
            'title' => '',
            'is_active' => true
        ]);

        $response->assertStatus(422);
        $response->assertUnprocessable()->assertJsonValidationErrors('title');

    }

    public function test_payment_method_by_id()
    {
        $paymentMethod = PaymentMethod::factory()->createOne();

        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson("api/payment_method/{$paymentMethod->id}");

        $response->assertOk();

        $this->assertArrayHasKey('data', $response->json());

    }

    public function test_payment_method_by_id_not_found()
    {
        $id = PHP_INT_MAX;
        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson("api/payment_method/{$id}");

        $response->assertNotFound();
    }

    public function test_payment_method_listing()
    {
        $paymentMethod = PaymentMethod::factory()->createOne();

        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson("api/payment_method?[filters][id]={$paymentMethod->id}");

        $response->assertOk();

        $this->assertArrayHasKey('data', $response->json());

        $this->assertCount(1, $response->json()['data']);
    }

    public function test_payment_method_update()
    {
        $paymentMethod = PaymentMethod::factory()->createOne();

        $updatedTitle = fake()->title();

        while($updatedTitle == $paymentMethod->title){
            $updatedTitle = fake()->title();
        }

        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->putJson("api/payment_method/{$paymentMethod->id}", [
                'title' => $updatedTitle,
                'is_active' => $paymentMethod->is_active
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('payment_methods', [
            'title' => $updatedTitle,
            'is_active' => $paymentMethod->is_active
        ]);

        $this->assertArrayHasKey('data', $response->json());
    }

    public function test_payment_method_delete()
    {
        $paymentMethod = PaymentMethod::factory()->createOne();

        $response = $this->withToken($this->authenticate())
            ->withHeaders(['Accept' => 'application/json'])
            ->deleteJson("api/payment_method/{$paymentMethod->id}");

        $response->assertNoContent();

        $this->assertNull(PaymentMethod::find($paymentMethod->id));

    }

    public function test_payment_method_delete_not_found()
    {
        $paymentMethod = PaymentMethod::factory()->createOne();
        $deletedId = $paymentMethod->id;
        $paymentMethod->delete();

        $response = $this->withToken($this->authenticate())->getJson("api/payment_method/{$deletedId}");

        $response->assertNotFound();

    }


}