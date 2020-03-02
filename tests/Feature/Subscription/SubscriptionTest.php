<?php


namespace Tests\Feature\Subscription;


use App\Service;
use App\Subscriber;
use App\Subscription;
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

    /**
     * @test
     * @testdox Test if user is already subscribed to a service.
     */
    public function caseTwo()
    {
        $service = factory(Service::class)->create(['is_disabled' => 0]);
        $subscriber = factory(Subscriber::class)->create(['blocked' =>0]);
        $subscription = [
            'msisdn' => $subscriber->msisdn,
            'service' => $service->description,
            'insert_date' => date('Y-m-d')
        ];
        $response = $this->json('POST', '/api/subscription', $subscription);
        $response->assertStatus(200);
        $data =json_decode($response->getContent());
        $response->assertJson([
            'success' => true,
            'code' => 200,
            'message' => 'MSISDN successfully subscribed',
            'data' => [
                'id' => $data->data->id,
            ]
        ]);

        $this->json('POST', '/api/subscription', $subscription)->assertStatus(422)
            ->assertJson([
                'message' => "The given data was invalid.",
            ]);
    }

    /**
     * @test
     * @testdox subscribe with blocker subscriber
     */
    public function caseThree()
    {
        $subscriber = factory(Subscriber::class)->create(['blocked'=>1]);
        $service = factory(Service::class)->create(['is_disabled'=>0]);

        $subscription = [
            'msisdn' => $subscriber->msisdn,
            'service' => $service->description,
            'insert_date' => date('Y-m-d')
        ];
        $response = $this->postJson( '/api/subscription', $subscription);
        $response->assertStatus(422);
    }

    /**
     * @test
     * @testdox subscribe with disabled service
     */
    public function caseFour()
    {
        $subscriber = factory(Subscriber::class)->create(['blocked'=>0]);
        $service = factory(Service::class)->create(['is_disabled'=>1]);

        $subscription = [
            'msisdn' => $subscriber->msisdn,
            'service' => $service->description,
            'insert_date' => date('Y-m-d')
        ];
        $response = $this->postJson( '/api/subscription', $subscription);
        $response->assertStatus(422);
    }
}
