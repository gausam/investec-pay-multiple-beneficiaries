<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\Investec;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        if (
            !$user->api_key ||
            !$user->client_id ||
            !$user->client_secret
        ) {
            return redirect()->route('profile.edit')->with('status', 'Please add Investec credentials.');
        }

        $itemsPerPage = 5;
        $urlPage = $request->get('page') ?? 1;

        $transactions = collect(Investec::getAccountTransactions());
        $payments = new LengthAwarePaginator( $transactions->forPage($urlPage, $itemsPerPage) , count($transactions), $itemsPerPage);
        $payments->withPath(route('history'));

        return view('history', [
            'payments' => $payments,
        ]);
    }
}
