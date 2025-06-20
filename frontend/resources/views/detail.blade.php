<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('dist/css/tabler-vendors.min.css') }}" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');
    </style>
</head>

<body class="d-flex flex-column">
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>
    <div class="page m-5">
        <table class="table table-bordered mb-3">
            <thead>
                <tr>
                    <td class="text-center" colspan="2">Detail Product</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Product Name</td>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>{{ $product->description }}</td>
                </tr>
                <tr>
                    <td>Material</td>
                    <td>{{ $product->material }}</td>
                </tr>
                <tr>
                    <td>Created at</td>
                    <td>{{ $product->created_at }}</td>
                </tr>
                <tr>
                    <td>Product Image</td>
                    <td><img class="mb-3" src="{{ asset('storage/' . $product->image) }}" width="200"
                            style="border-radius: 8px" /></td>
                </tr>
                <tr>
                    <td>Blockchain Hash</td>
                    <td>{{ $product->blockchain_hash }}</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered mb-3">
            <thead>
                <tr>
                    <td class="text-center" colspan="5">Stage Product</td>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th>Stage Name</th>
                    <th>Location</th>
                    <th>Executor</th>
                    <th>Date</th>
                    <th>Blockchain Hash</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach ($stages as $stage)
                    <tr>
                        <td data-label="Name">{{ $stage->stage_name }}</td>
                        <td data-label="Location">{{ $stage->location }}</td>
                        <td data-label="Executor">{{ $stage->performed_by }}</td>
                        <td data-label="Date">{{ $stage->performed_at }}</td>
                        <td data-label="Blockchain Hash">
                            {{ $stage->blockchain_hash ? Str::limit($stage->blockchain_hash, 20) : '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="table table-bordered mb-3">
            <thead>
                <tr>
                    <td class="text-center" colspan="4">Stage Product</td>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th>Destination</th>
                    <th>Received By</th>
                    <th>Date</th>
                    <th>Blockchain Hash</th>
                </tr>
            </thead>
            <tbody id="tableBody1">
                @foreach ($distributions as $stage)
                    <tr>
                        <td data-label="Name">{{ $stage->destination }}</td>
                        <td data-label="Location">{{ $stage->distributor->name }}
                        </td>
                        <td data-label="Executor">{{ $stage->distributed_at }}
                        </td>
                        <td data-label="Blockchain Hash">
                            {{ $stage->blockchain_hash ? Str::limit($stage->blockchain_hash, 20) : '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('dist/js/tabler.min.js') }}" defer></script>
</body>

</html>
