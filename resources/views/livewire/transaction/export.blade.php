<?php

use App\Models\User;
use App\Models\ProductTransaction;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

// $transactions = '';
// new class extends Component
// {

//     /**
//      * Mount the component.
//      */
//     public function __construct()
//     {
//         $this->transactions = ;
//     }
// };

$transactions = ProductTransaction::all();
foreach ($transactions as $trans) {
    $transactions->product = $trans->product;
}
// echo json_encode($transactions);
// $trans = json_decode($transactions)
 ?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- <script src="https://unpkg.com/jspdf@2.5.2/dist/jspdf.umd.min.js"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            <!-- Page Content -->
            <main id="main" class="py-3 px-4 ">
                <header>
                    <h2 class="text-xl font-bold">
                        {{ __('Transactions') }}
                    </h2>
                </header>

                <x-table>
                    <x-slot name="head">
                        <x-table.header>Image</x-table.header>
                        <x-table.header>Product</x-table.header>
                        <x-table.header>Desc</x-table.header>
                        <x-table.header>Type</x-table.header>
                        <x-table.header>From / To</x-table.header>
                        <x-table.header>Qty</x-table.header>
                        <x-table.header>Price</x-table.header>
                        <x-table.header>Total Price</x-table.header>
                    </x-slot>
                    <x-slot name="body">
                        @if (count($transactions) == 0)
                        <x-table.row>
                            <x-table.cell colspan="12" class="text-center">No Data</x-table.cell>
                        </x-table.row>
                        @endif
                        @php
                            $totalIncome=0;
                        @endphp
                        @foreach ($transactions as $transaction)
                        <x-table.row class="break-after-auto">
                            <x-table.cell width="25%"> <img class="mx-auto" width="230" src="{{ asset($transaction->product->image) }}"  alt=""> </x-table.cell>
                            <x-table.cell>{{ $transaction->product->name }}</x-table.cell>
                            <x-table.cell>{{ $transaction->product->desc }}</x-table.cell>
                            <x-table.cell>{{ $transaction->is_out == '0' ? "Bought" : "Sold" }}</x-table.cell>
                            <x-table.cell>{{ $transaction->from_or_to }}</x-table.cell>
                            <x-table.cell>{{ $transaction->qty }}</x-table.cell>
                            <x-table.cell class="text-end">{{ preg_replace('/\B(?=(\d{3})+(?!\d))/i', '.', $transaction->product->price) }}</x-table.cell>
                            @php
                                $total = ($transaction->qty * $transaction->product->price) * ($transaction->is_out == '0' ? -1 : 1);
                                $totalIncome += $total;
                            @endphp
                            <x-table.cell  class="text-end">{{ preg_replace('/\B(?=(\d{3})+(?!\d))/i', '.', $total) }}</x-table.cell>
                        </x-table.row>
                        @endforeach
                        <x-table.row class="break-inside-avoid-page">
                            <x-table.cell colspan="5" class="text-end">Transaction Count</x-table.cell>
                            <x-table.cell>{{ count($transactions) }}</x-table.cell>
                            <x-table.cell class="text-end">Total</x-table.cell>
                            <x-table.cell class="text-end">{{ preg_replace('/\B(?=(\d{3})+(?!\d))/i', '.', $totalIncome) }}</x-table.cell>
                        </x-table.row>
                    </x-slot>
                </x-table>
            </main>
        </div>
    </body>
    <script>
        const body = document.getElementById('main');
        const dateNow = new Date();
        const filename = `export_transaction_${dateNow.getFullYear().toString() + (dateNow.getMonth() + 1).toString() + dateNow.getDate().toString()}.pdf`
        const opt = {
            pagebreak: {mode: 'css'},
            margin: 1,
            filename: filename,
            image : { type: 'jpeg', quality: '0.98'},
            jsPDF: {unit: 'cm', 'format' : 'legal', orientation: 'landscape'}
        }
        html2pdf(body, opt);
    </script>
</html>