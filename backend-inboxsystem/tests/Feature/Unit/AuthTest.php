<?php

namespace Tests\Feature\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use App\Interfaces\Auth\AuthServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\DTOs\Auth\SignInData;
use App\Actions\Auth\SignInAction;

class AuthTest extends TestCase
{
    public function test_execute_calls_auth_service()
    {
        $service = Mockery::mock(AuthServiceInterface::class);
        $dto = new SignInData( 'test@test.com', 'password' );

        $service
            ->shouldReceive('signIn')
            ->once()
            ->with($dto)
            ->andReturn([ 'access_token' => 'token' ]);

        $action = new SignInAction($service);

        $this->assertEquals( 'token', $action->execute($dto)['access_token'] );
    }

}
