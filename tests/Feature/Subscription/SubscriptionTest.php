<?php


namespace Tests\Feature\Subscription;


use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use phpDocumentor\Reflection\Types\Integer;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * @test
     * @testdox Test saving a subscription. Returns 200 if ok, 422 if error with subscriber or service.
     * @testWith
     *          ["+54123456789","*5050",422]
     *          ["+54123456789","*2020",200]
     *          ["+54789789411","RingBackTones",422]
     *          ["+54123456789","*2020",200]
     *          ["any","*2020",422]
     *          ["+54123457877","*2020",422]
     * @param string $msisdn
     * @param string $service
     * @param $expected
     */
    public function caseOne(string $msisdn, string $service, $expected )
    {
        $faker = \Faker\Factory::create();
        $subscription = [
            'msisdn' => $msisdn,
            'service' => $service,
            'insert_date' => date('Y-m-d')
        ];

        $response = $this->json('POST','/api/subscription',$subscription);
        $response->assertStatus($expected);
    }
}
