<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Catatan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body>

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="nav-link text-white" href="{{ route('sales.index') }}">Penjualan</a>
            <a class="nav-link text-white" href="{{ route('payments.index') }}">Pembayaran</a>
        </div>
    </nav>


    @yield('content')

    @yield('scripts')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</body>

</html>