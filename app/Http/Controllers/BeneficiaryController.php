<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\Investec;
use App\Services\Payment;
use App\Http\Requests\InitiatePaymentRequest;

class BeneficiaryController extends Controller
{
    public function index() {
        $user = Auth::user();
        if (
            !$user->api_key ||
            !$user->client_id ||
            !$user->client_secret
        ) {
            return redirect()->route('profile.edit')->with('status', 'Please add Investec credentials.');
        }

        $beneficiaries = Investec::getBeneficiaries();
        return view('dashboard', [ 'beneficiaries' => $beneficiaries ]);
    }

    /**
     * Initiate payment request.
     *
     * @param  \App\Http\Requests\InitiatePaymentRequest  $request
     * @return Illuminate\Http\Response
     */
    public function pay(InitiatePaymentRequest $request) {
        $beneficiaries = collect($request->get('beneficiaries'))->filter(function ($beneficiary) {
            return (float) $beneficiary['amount'] > 0;
        });

        $paymentsList = [];

        foreach($beneficiaries as $beneficiary) {
            $paymentsList[] = new Payment($beneficiary['id'], $beneficiary['amount'], 'Pay Multi', 'Pay Multi');
        }

        Investec::payMultiple($paymentsList);
        return redirect()->route('history')->with('status', 'Beneficiaries paid successfully.');
    }
}
