@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Penjualan</h4>

    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Item</th>
                    <th width="100">Qty</th>
                    <th width="150">Harga</th>
                    <th width="150">Subtotal</th>
                    <th width="80">Aksi</th>
                </tr>
            </thead>

            <tbody id="itemsBody">
                @foreach($sale->items as $i => $row)
                <tr>
                    <td>
                        <select name="items[{{ $i }}][item_id]" class="form-control item-select">
                            <option value="">-- pilih item --</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}"
                                data-price="{{ $item->price }}"
                                {{ $item->id == $row->item_id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $i }}][qty]"
                            class="form-control qty" value="{{ $row->qty }}" min="1">
                    </td>
                    <td>
                        <input type="number" name="items[{{ $i }}][price]"
                            class="form-control price" value="{{ $row->price }}" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control subtotal"
                            value="{{ $row->total_price }}" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button"
            class="btn btn-secondary mb-3"
            id="addRow"
            data-index="{{ $sale->items->count() }}">
            + Tambah Item
        </button>

        <div class="mb-3">
            <h5>Total: Rp <span id="grandTotal">0</span></h5>
        </div>

        <button class="btn btn-primary">Update Penjualan</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Batal</a>
    </form>
    <template id="itemRowTemplate">
        <tr>
            <td>
                <select class="form-control item-select">
                    <option value="">-- pilih item --</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                        {{ $item->name }}
                    </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" class="form-control qty" value="1" min="1">
            </td>
            <td>
                <input type="number" class="form-control price" readonly>
            </td>
            <td>
                <input type="number" class="form-control subtotal" value="0" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
            </td>
        </tr>
    </template>

</div>
@endsection

@section('scripts')
<script>
    const tbody = document.getElementById('itemsBody');
    const addBtn = document.getElementById('addRow');
    let index = parseInt(addBtn.dataset.index);

    // hitung subtotal & total
    function hitung() {
        let total = 0;
        document.querySelectorAll('#itemsBody tr').forEach(row => {
            const qty = parseInt(row.querySelector('.qty')?.value) || 0;
            const price = parseInt(row.querySelector('.price')?.value) || 0;
            const subtotal = qty * price;
            row.querySelector('.subtotal').value = subtotal;
            total += subtotal;
        });
        document.getElementById('grandTotal').innerText = total.toLocaleString();
    }

    // pilih item → set harga
    document.addEventListener('change', e => {
        if (e.target.classList.contains('item-select')) {
            const row = e.target.closest('tr');
            const price = e.target.options[e.target.selectedIndex]?.dataset.price || 0;
            row.querySelector('.price').value = price;
            hitung();
        }
    });

    // ubah qty
    document.addEventListener('input', e => {
        if (e.target.classList.contains('qty')) hitung();
    });

    // tambah item
    addBtn.addEventListener('click', () => {
        const template = document.getElementById('itemRowTemplate');
        const newRow = template.content.cloneNode(true).querySelector('tr');

        newRow.querySelector('.item-select').name = `items[${index}][item_id]`;
        newRow.querySelector('.qty').name = `items[${index}][qty]`;
        newRow.querySelector('.price').name = `items[${index}][price]`;

        tbody.appendChild(newRow);
        index++;
    });

    // hapus baris
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-row')) {
            if (tbody.querySelectorAll('tr').length > 1) {
                e.target.closest('tr').remove();
                hitung();
            }
        }
    });

    hitung();
</script>
@endsection