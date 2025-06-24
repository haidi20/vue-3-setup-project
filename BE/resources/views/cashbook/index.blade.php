@extends('layouts.main')

@section('content')
    <header class="header">
        <h5 class="mb-0">Cash Book</h5>
    </header>
    <main class="content">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $balance = 0;
                                @endphp
                                @forelse($data as $index => $item)
                                    @php
                                        $amount = $item->amount;
                                        if ($item->type === 'in') {
                                            $debit = $amount;
                                            $credit = 0;
                                            $balance += $amount;
                                        } else {
                                            $debit = 0;
                                            $credit = $amount;
                                            $balance -= $amount;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $item->transaction_date_readable }}</td>
                                        <td>
                                            <strong>{{ $item->description }}</strong><br>
                                            <small>
                                                No Dokumen: {{ $item->document_number ?? '-' }}<br>
                                                Akun: {{ $item->account_estimate_name }}<br>
                                                Sumber: {{ $item->funding_source_name }}<br>
                                                Jenis: {{ $item->payment_type_name }}<br>
                                                Unit: {{ $item->organizational_unit_name }}<br>
                                                @if (!empty($item->reference))
                                                    Referensi: {{ $item->reference }}<br>
                                                @endif
                                                Dibuat: {{ $item->created_at ?? '-' }}<br>
                                            </small>
                                        </td>
                                        <td>{{ $item->debit_readable }}</td>
                                        <td>{{ $item->credit_readable }}</td>
                                        <td>{{ $item->balance_readable }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No data available.</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination links --}}
                    <div class="d-flex justify-content-center">
                        {{ $data->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
