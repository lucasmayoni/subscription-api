<?php


namespace Tests\Unit\Controller;


use App\Http\Controllers\Controller;
use App\Http\Controllers\SubscriptionController;
use Faker\Generator;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    /**
     * @test
     * @testdox Test Controller are instantiable
     */
    public function caseOne()
    {
        $this->assertInstanceOf(Controller::class, resolve(SubscriptionController::class));
    }


}
