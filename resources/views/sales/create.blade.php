@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Penjualan</h4>

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <table class="table table-bordered" id="itemsTable">
            <thead>
                <tr>
                    <th>Item</th>
                    <th width="120">Qty</th>
                    <th width="150">Harga</th>
                    <th width="150">Subtotal</th>
                    <th width="80">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="items[0][item_id]" class="form-control item-select" required>
                            <option value="">-- pilih item --</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[0][qty]" class="form-control qty" value="1" min="1">
                    </td>
                    <td>
                        <input type="number" name="items[0][price]" class="form-control price" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control subtotal" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-secondary mb-3" id="addRow">+ Tambah Item</button>

        <div class="mb-3">
            <h5>Total: Rp <span id="grandTotal">0</span></h5>
        </div>

        <button class="btn btn-primary">Simpan Penjualan</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    let index = 1;

    function hitung() {
        let total = 0;
        document.querySelectorAll('#itemsTable tbody tr').forEach(row => {
            const qty = row.querySelector('.qty').value || 0;
            const price = row.querySelector('.price').value || 0;
            const subtotal = qty * price;
            row.querySelector('.subtotal').value = subtotal;
            total += subtotal;
        });
        document.getElementById('grandTotal').innerText = total.toLocaleString();
    }

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('item-select')) {
            const price = e.target.options[e.target.selectedIndex].dataset.price || 0;
            const row = e.target.closest('tr');
            row.querySelector('.price').value = price;
            hitung();
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('qty')) {
            hitung();
        }
    });

    document.getElementById('addRow').addEventListener('click', function() {
        const tbody = document.querySelector('#itemsTable tbody');
        const newRow = tbody.rows[0].cloneNode(true);

        newRow.querySelectorAll('input, select').forEach(el => el.value = '');
        newRow.querySelector('.qty').value = 1;

        newRow.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
        });

        tbody.appendChild(newRow);
        index++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            const rows = document.querySelectorAll('#itemsTable tbody tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                hitung();
            }
        }
    });
</script>
@endsection