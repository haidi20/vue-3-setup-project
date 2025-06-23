@extends('layouts.main')

@section('content')
    <header class="header">
        <h5 class="mb-0">Dashboard</h5>
    </header>
    <main class="content">
        <div class="container mt-5">
            <div class="row">
                @foreach ($dataCounts as $index => $item)
                    <div class="col-md-4 mb-3">
                        <div
                            class="card
                            @if ($index % 3 == 0) text-bg-primary
                            @elseif($index % 3 == 1) text-bg-success
                            @else text-bg-warning @endif
                        ">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item['label'] }}</h5>
                                <p class="card-text">{{ $item['value'] }} data</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
