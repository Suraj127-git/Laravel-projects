<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Exception;

class InstamojoController extends Controller
{
    public function payment_request(Request $request)
    {

        // if(env('INSTAMOJO_ENVIRONMENT') == 'sandbox') {
        //     $url = 'https://test.instamojo.com/api/1.1/payment-requests/';
        // } else {
        //     $url = 'https://www.instamojo.com/api/1.1/payment-requests/';
        // }

        // $api_key = env('INSTAMOJO_API_KEY');
        // $auth_token = env('INSTAMOJO_AUTH_TOKEN');
        // // echo $auth_token;die;
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
        // curl_setopt($ch, CURLOPT_HEADER, FALSE);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        // curl_setopt($ch, CURLOPT_HTTPHEADER,
        //             array("X-Api-Key:elTAa4n5hB7Wp07JkSjRh1Af47QZBcXCJ0ijCOuR",
        //             "X-Auth-Token:4Oz2f9deOA4GO9AEdoBhc0oEZ4BQP4bM9GBPIo0OEnjREECgV9OCHas9fkABi2KFy0nC9FPXfVciGKRFIyooMfH3OdhzrG4EzF465QU7QY68NtoHJVEUZqHu404EI6JF"));
        // $payload = Array(
        //     'purpose' => 'application',
        //     'amount' => '100',
        //     'phone' => '9999999999',
        //     'buyer_name' => 'suraj',
        //     'redirect_url' => route('instamojo_success'),
        //     'send_email' => true,
        //     'webhook' => 'http://www.example.com/webhook/',
        //     'send_sms' => true,
        //     'email' => 'test@yourwebsite.com',
        //     'allow_repeated_payments' => false
        // );
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        // $response = curl_exec($ch);
        // curl_close($ch); 
        // $response = json_decode($response);
        // dd($response);
        $authType = 'app';
        $api = \Instamojo\Instamojo::init($authType, [
            'client_id' => 'elTAa4n5hB7Wp07JkSjRh1Af47QZBcXCJ0ijCOuR',
            'client_secret' => '4Oz2f9deOA4GO9AEdoBhc0oEZ4BQP4bM9GBPIo0OEnjREECgV9OCHas9fkABi2KFy0nC9FPXfVciGKRFIyooMfH3OdhzrG4EzF465QU7QY68NtoHJVEUZqHu404EI6JF'
        ], false);
        
        try {
            $response = $api->createPaymentRequest(array(
                "purpose" => "FIFA 16",
                "amount" => '100',
                "buyer_name" => "suraj",
                "send_email" => false,
                "email" => "test@suraj.com",
                "phone" => "9999999999",
                "redirect_url" => route('instamojo_success')
            ));
        
            session()->put('user_name', 'suraj');
            return redirect($response['longurl']);
            exit();
        } catch (Exception $e) {
            print('Error: ' . $e->getMessage());
            // return redirect()->route('error');
        }
    }
    public function payment_response(Request $request)
    {
        //dd($request->all());

        if(env('INSTAMOJO_ENVIRONMENT') == 'sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/payments/'.$request->payment_id;
        } else {
            $url = 'https://www.instamojo.com/api/1.1/payments/'.$request->payment_id;
        }

        $api_key = env('INSTAMOJO_API_KEY');
        $auth_token = env('INSTAMOJO_AUTH_TOKEN');

        if(isset($request->payment_id) && $request->payment_id != null) {
            
            try {
                $api = new \Instamojo\Instamojo(
                    env('INSTAMOJO_API_KEY'),
                    env('INSTAMOJO_AUTH_TOKEN'),
                    env('INSTAMOJO_URL'),
                );
                $response = $api->getPaymentRequests(
                    request('payment_request_id')
                );
                if (!isset($response['payments'][0]['status'])) {
                    return back()->withError('Payment failed');
                }
                if ($response['payments'][0]['status'] != 'Credit') {
                    return back()->withError('Payment failed');
                }
                return back()->withSuccess('Payment done');
            } catch (\Exception $e) {
                return back()->withError('Payment failed');
            }
            dd($response);
        }
    }
}