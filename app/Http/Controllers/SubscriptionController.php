<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionDeleteRequest;
use App\Http\Requests\SubscriptionStoreRequest;
use App\Service;
use App\Subscriber;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    /**
     * @var Subscription
     */
    private $subscription;
    /**
     * @var Service
     */
    private $service;
    /**
     * @var Subscriber
     */
    private $subcriber;

    public function __construct(Subscription $subscription, Subscriber $subscriber, Service $service)
    {
        $this->subscription = $subscription;
        $this->service = $service;
        $this->subcriber = $subscriber;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(SubscriptionStoreRequest $request)
    {
        try {

            $fields = $request->all();
            $subscription = new Subscription([
                'subscriber_id' => $this->subcriber->findByMsisdn($fields['msisdn']),
                'service_id' => $this->service->findByServiceName($fields['service']),
                'insert_date' => $fields['insert_date']
            ]);
            $subscription->save();

            $message = [
                'success' => true,
                'code' => 200,
                'message' => 'MSISDN successfully subscribed',
                'data' => $subscription
            ];

        } catch (\Exception $e) {
            $message = [
                'success' => false,
                'code' => $e->getCode(),
                "message" => trans('errors.internal-server-error'),
                "errors" => $e->getMessage(),
                'data' => []
            ];
        }
        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param SubscriptionDeleteRequest $request
     * @return array
     */
    public function destroy($id, SubscriptionDeleteRequest $request)
    {

    }

    /**
     * @param SubscriptionDeleteRequest $request
     * @return array
     */
    public function deleteSubscription(SubscriptionDeleteRequest $request)
    {
        try {

            $fields = $request->all();
            $subscription = $this->subscription->findWithParams($fields['msisdn'], $fields['service']);
            $subscription->delete();

            $message = [
                'success' => true,
                'code' => 200,
                'message' => 'MSISDN successfully unsubscribed',
                'data' => []
            ];

        } catch (\Exception $e) {
            $message = [
                'success' => false,
                'code' => $e->getCode(),
                "message" => trans('errors.internal-server-error'),
                "errors" => $e->getMessage(),
                'data' => []
            ];
        }
        return $message;
    }
}
