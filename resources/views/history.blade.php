<x-app-layout>

    <x-slot name="header">
        {{ __('History') }}
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-5">
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr class="divide-x divide-gray-200">
                                    <th scope="col" class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">Description</th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Amount</th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Transaction Type</th>
                                    <th scope="col" class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pr-6">Transaction Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">

                                @foreach($payments as $payment)
                                    <tr class="divide-x divide-gray-200">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">{{ $payment->description }}</td>
                                        <td class="whitespace-nowrap p-4 text-sm text-gray-500 text-right">R{{ number_format($payment->amount, 2) }}</td>
                                        <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ $payment->transactionType }}</td>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm text-gray-500 sm:pr-6">{{ $payment->transactionDate }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ $payments->links() }}

</x-app-layout>
