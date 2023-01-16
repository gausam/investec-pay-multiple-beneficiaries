<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use WpOrg\Requests\Requests;
use WpOrg\Requests\Auth\Basic;

use App\Models\User;

class Investec {

    public static function getAccounts() {
        $token = static::getToken();
        $response = Requests::get(
            'https://openapi.investec.com/za/pb/v1/accounts',
            [
                'Authorization' => 'Bearer ' . $token,
            ]
        );

        if (!$response->success) {
            throw new \Exception("Failed to retrieve accounts");
        }

        $accounts = json_decode($response->body);
        return $accounts->data->accounts;
    }

    public static function getAccountTransactions() {
        $accounts = static::getAccounts();
        $account = $accounts[0];
        $endpoint = "https://openapi.investec.com/za/pb/v1/accounts/" . $account->accountId . "/transactions";

        $token = static::getToken();
        $response = Requests::get(
            $endpoint,
            [
                'Authorization' => 'Bearer ' . $token,
            ]
        );

        if (!$response->success) {
            throw new \Exception("Failed to retrieve account transactions");
        }

        $transactions = json_decode($response->body);
        return $transactions->data->transactions;
    }

    public static function getBeneficiaries() {
        $token = static::getToken();
        $response = Requests::get(
            'https://openapi.investec.com/za/pb/v1/accounts/beneficiaries',
            [
                'Authorization' => 'Bearer ' . $token,
            ]
        );

        if (!$response->success) {
            throw new \Exception("Failed to retrieve beneficiaries");
        }

        $beneficiaries = json_decode($response->body);
        return $beneficiaries->data;
    }

    public static function payMultiple($paymentsList) {
        $accounts = static::getAccounts();
        $account = $accounts[0];
        $endpoint = 'https://openapi.investec.com/za/pb/v1/accounts/' . $account->accountId .'/paymultiple';
        $token = static::getToken();
        $data = (object)[ 'paymentList' => $paymentsList ];

        $response = Requests::post(
            $endpoint,
            [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
            json_encode($data)
        );

        if (!$response->success) {
            Log::error($response->body);
            throw new \Exception("Failed to pay beneficiaries.");
        }
    }

    public static function getToken() {
        $user = Auth::user();
        $options = array(
            'auth' => new Basic(array(
                $user->client_id,
                $user->client_secret
            ))
        );

        $response = Requests::post(
            'https://openapi.investec.com/identity/v2/oauth2/token',
            [
                'x-api-key' => $user->api_key,
                'Content-Type' => 'application/x-www-form-urlencoded',   
            ],
            [
                'grant_type' => 'client_credentials',
                'scope' => 'accounts',
            ],
            $options
        );

        if (!$response->success) {
            throw new \Exception('Authentication failed');
        }

        $credentials = json_decode( $response->body );
        $accessToken = $credentials->access_token;
        return $accessToken;
    }

}
