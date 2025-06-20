@if (auth()->user()->role == 'produsen')
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="row">
                        <div class="col-6">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-cyan-lt text-white avatar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon m-0">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M6 12l6 -9l6 9l-6 9z" />
                                                    <path d="M6 12l6 -3l6 3l-6 2z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                {{ $totalProducts }} Product
                                            </div>
                                            <div class="text-secondary">
                                                Distribution
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-purple-lt text-white avatar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-medium">
                                                {{ $totalStages }} Stages
                                            </div>
                                            <div class="text-secondary">
                                                Product
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="m-0">
                                Product has not been distributed yet
                            </h3>
                        </div>
                        <div class="card-header">
                            <div class="input-icon w-100">
                                <input type="text" id="searchInput" value="" class="form-control"
                                    placeholder="Search…">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                        <path d="M21 21l-6 -6"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter table-mobile-md card-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Material</th>
                                        <th>Blockchain Hash</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($products as $data)
                                        <tr>
                                            <td data-label="Name">
                                                {{ $data->name }}
                                            </td>
                                            <td data-label="Description">
                                                {{ $data->description }}
                                            </td>
                                            <td data-label="Material">
                                                {{ $data->material }}
                                            </td>
                                            <td data-label="Blockchain Hash">
                                                {{ $data->blockchain_hash ? Str::limit($data->blockchain_hash, 20) : '' }}
                                            </td>
                                            <td>
                                                <div class="text-end">
                                                    <form action="{{ route('stage.distribution', $data->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $data->id }}">
                                                        <button type="submit" class="btn btn-outline-primary btn-5">
                                                            <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-2">
                                                                <path d="M12 5l0 14" />
                                                                <path d="M5 12l14 0" />
                                                            </svg>
                                                            Distribution
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer pb-0">
                            <div class="d-flex justify-content-center" id="paginationContainer" hidden>
                                <ul class="pagination" id="paginationWrapper">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                            <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M15 6l-6 6l6 6"></path>
                                            </svg>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-right -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M9 6l6 6l-6 6"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
@endif
