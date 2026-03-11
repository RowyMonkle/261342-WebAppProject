<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($payments as $payment)
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100">Payment ID: {{ $payment->payment_id }}</h3>
                            <p class="text-green-600 font-bold mt-1">Amount: ฿{{ number_format($payment->amount, 2) }}</p>
                            <p class="text-sm text-gray-500 mt-1">Date: {{ $payment->created_at->format('Y-m-d') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No payments found.</p>
                @endforelse
            </div>
        </div>
    </div>

</x-app-layout>