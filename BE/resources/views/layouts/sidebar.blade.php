<nav class="sidebar d-flex flex-column p-3">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">Inventory</span>
    </a>
    <hr>

    @php
        $menuItems = [
            'Dashboard' => [
                'name' => 'Dashboard',
                'route' => 'dashboard',
                'icon' => 'bi-speedometer2',
            ],
            'Keuangan' => [
                'items' => [
                    [
                        'name' => 'Pembukuan Kas',
                        'route' => 'cash-books.index',
                        'icon' => 'bi-journal-text',
                    ],
                    [
                        'name' => 'Rekening Bank',
                        'route' => 'bank-accounts.index',
                        'icon' => 'bi-building',
                    ],
                    [
                        'name' => 'Rekonsiliasi Bank',
                        'route' => 'bank-reconciliation.index',
                        'icon' => 'bi-check-square',
                    ],
                    [
                        'name' => 'Rekonsiliasi Produk',
                        'route' => 'product-reconciliation.index',
                        'icon' => 'bi-check-square',
                    ],
                    [
                        'name' => 'Laporan',
                        'route' => 'reports.index',
                        'icon' => 'bi-file-earmark-bar-graph',
                    ],
                ],
            ],
            'Akuntansi' => [
                'items' => [
                    [
                        'name' => 'Antrian Jurnal',
                        'route' => 'queue-journals.index',
                        'icon' => 'bi-list-ul',
                    ],
                    [
                        'name' => 'Jurnal Umum',
                        'route' => 'general-journals.index',
                        'icon' => 'bi-journal-text',
                    ],
                    [
                        'name' => 'Buku Besar',
                        'route' => 'ledger.index',
                        'icon' => 'bi-book',
                    ],
                    [
                        'name' => 'Neraca Saldo',
                        'route' => 'trial-balance.index',
                        'icon' => 'bi-calculator',
                    ],
                    [
                        'name' => 'Penyesuaian',
                        'route' => 'reconciliation.index',
                        'icon' => 'bi-arrow-repeat',
                    ],
                    [
                        'name' => 'Tutup Buku (Periode)',
                        'route' => 'closing-period.index',
                        'icon' => 'bi-calendar-check',
                    ],
                    [
                        'name' => 'Laporan',
                        'route' => 'accounting-reports.index',
                        'icon' => 'bi-file-earmark-bar-graph',
                    ],
                ],
            ],
            'Data Dasar' => [
                'items' => [
                    [
                        'name' => 'Akun Perkiraan',
                        'route' => 'chart-of-accounts.index',
                        'icon' => 'bi-list-ul',
                    ],
                    [
                        'name' => 'Rekening Bank',
                        'route' => 'bank-accounts.index',
                        'icon' => 'bi-building',
                    ],
                    [
                        'name' => 'Sumber Dana',
                        'route' => 'funding-sources.index',
                        'icon' => 'bi-cash-stack',
                    ],
                    [
                        'name' => 'Jenis Transaksi',
                        'route' => 'transaction-types.index',
                        'icon' => 'bi-exchange-alt',
                    ],
                    [
                        'name' => 'Jenis Pembayaran',
                        'route' => 'payment-types.index',
                        'icon' => 'bi-credit-card',
                    ],
                    [
                        'name' => 'Unit Organisasi',
                        'route' => 'organizational-units.index',
                        'icon' => 'bi-building-columns',
                    ],
                    [
                        'name' => 'Periode Akuntansi',
                        'route' => 'accounting-periods.index',
                        'icon' => 'bi-calendar-date',
                    ],
                ],
            ],
            'Pengaturan' => [
                'items' => [
                    [
                        'name' => 'Pengguna',
                        'route' => 'users.index',
                        'icon' => 'bi-person-fill',
                    ],
                    [
                        'name' => 'Integrasi',
                        'route' => 'integrations.index',
                        'icon' => 'bi-arrow-right-square',
                    ],
                ],
            ],
        ];
    @endphp

    <!-- Dashboard -->
    <ul class="nav nav-pills flex-column mb-auto">
        @foreach ($menuItems as $key => $section)
            @if ($key === 'Dashboard')
                <li class="nav-item">
                    <a href="{{ route($section['route']) }}"
                        class="nav-link @if (Request::routeIs($section['route'])) active @endif">
                        <i class="bi {{ $section['icon'] }}"></i>
                        {{ $section['name'] }}
                    </a>
                </li>
            @else
                <h6
                    class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-uppercase">
                    <span>{{ $key }}</span>
                </h6>
                <ul class="nav nav-pills flex-column mb-auto">
                    @foreach ($section['items'] as $item)
                        <li class="nav-item">
                            <a href="{{ route($item['route']) }}"
                                class="nav-link @if (Request::routeIs($item['route'])) active @endif">
                                <i class="bi {{ $item['icon'] }}"></i>
                                {{ $item['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    </ul>
</nav>

<style>
    .sidebar h6 {
        color: #fff;
    }
</style>
