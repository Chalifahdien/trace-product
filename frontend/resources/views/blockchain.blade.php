@extends('layouts.app')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Home / Blockchain
                    </div>
                    <h2 class="page-title">
                        Blockchain
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container">
            <div class="card pb-3">
                <div class="table-responsive d-flex">
                    @forelse ($blocks as $block)
                        @if ($block['blockNumber'] != 0)
                            <div class="mt-4 me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-md">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M13 18l6 -6" />
                                    <path d="M13 6l6 6" />
                                </svg>
                            </div>
                        @endif
                        <div class="col-3 mt-3 me-3 @if ($block['blockNumber'] == 0) ms-3 @endif">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white">
                                    <strong>Block #{{ $block['blockNumber'] }}</strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>Hash:</strong> {{ $block['hash'] }}</p>
                                    <p><strong>Parent Hash:</strong> {{ $block['parentHash'] }}</p>
                                    <p><strong>Miner:</strong> {{ $block['miner'] }}</p>
                                    <p><strong>Gas Used:</strong> {{ number_format($block['gasUsed']) }}</p>
                                    <p><strong>Waktu:</strong>
                                        {{ \Carbon\Carbon::createFromTimestamp($block['timestamp'])->translatedFormat('l, d F Y H:i') }}
                                    </p>

                                    <h5 class="mt-4">Transactions</h5>
                                    @if (count($block['transactions']) > 0)
                                        <ul class="list-group">
                                            @foreach ($block['transactions'] as $tx)
                                                <li class="list-group-item">
                                                    <p><strong>Hash:</strong> {{ $tx['hash'] }}</p>
                                                    <p><strong>From:</strong> {{ $tx['from'] }}</p>
                                                    <p><strong>To:</strong> {{ $tx['to'] ?? '-' }}</p>
                                                    <p><strong>Value:</strong> {{ $tx['value'] }} wei</p>
                                                    <details>
                                                        <summary>Data</summary>
                                                        <pre class="text-wrap">{{ $tx['data'] }}</pre>
                                                    </details>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Tidak ada transaksi dalam blok ini.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning">
                            Tidak ada data blok ditemukan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('tableBody');
            const rows = Array.from(tableBody.getElementsByTagName('tr'));
            const paginationWrapper = document.getElementById('paginationWrapper');
            const rowsPerPage = 10;
            let currentPage = 1;

            function filterRows(query) {
                const lowerQuery = query.toLowerCase();
                return rows.filter(row => {
                    return Array.from(row.cells).some(cell =>
                        cell.textContent.toLowerCase().includes(lowerQuery)
                    );
                });
            }

            function renderTable(filteredRows) {
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                tableBody.innerHTML = '';
                filteredRows.slice(start, end).forEach(row => tableBody.appendChild(row));
                renderPagination(filteredRows.length);
            }

            function renderPagination(totalRows) {
                const pageCount = Math.ceil(totalRows / rowsPerPage);
                const paginationWrapper = document.getElementById("paginationWrapper");
                const paginationContainer = document.getElementById("paginationContainer");

                // Sembunyikan pagination jika hanya 1 halaman
                if (pageCount <= 1) {
                    paginationWrapper.innerHTML = '';
                    paginationContainer.hidden = true;
                    return;
                } else {
                    paginationContainer.hidden = false;
                }

                const maxVisiblePages = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = startPage + maxVisiblePages - 1;

                if (endPage > pageCount) {
                    endPage = pageCount;
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }

                paginationWrapper.innerHTML = '';

                // Prev Button
                const prev = document.createElement('li');
                prev.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prev.innerHTML = `<a class="page-link" href="#">‹</a>`;
                prev.onclick = e => {
                    e.preventDefault();
                    if (currentPage > 1) {
                        currentPage--;
                        renderTable(filterRows(searchInput.value));
                    }
                };
                paginationWrapper.appendChild(prev);

                // Page Numbers
                for (let i = startPage; i <= endPage; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                    li.onclick = e => {
                        e.preventDefault();
                        currentPage = i;
                        renderTable(filterRows(searchInput.value));
                    };
                    paginationWrapper.appendChild(li);
                }

                // Next Button
                const next = document.createElement('li');
                next.className = `page-item ${currentPage === pageCount ? 'disabled' : ''}`;
                next.innerHTML = `<a class="page-link" href="#">›</a>`;
                next.onclick = e => {
                    e.preventDefault();
                    if (currentPage < pageCount) {
                        currentPage++;
                        renderTable(filterRows(searchInput.value));
                    }
                };
                paginationWrapper.appendChild(next);
            }


            searchInput.addEventListener('input', () => {
                currentPage = 1;
                const filtered = filterRows(searchInput.value);
                renderTable(filtered);
            });

            renderTable(rows);
        });
    </script>
@endsection
