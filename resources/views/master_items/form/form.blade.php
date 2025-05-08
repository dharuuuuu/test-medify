<form method="POST" enctype="multipart/form-data">
    @csrf

    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{ $item->kode ?? '' }}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{ $item->nama ?? '' }}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{ $item->harga_beli ?? '' }}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required value="{{ $item->laba ?? '' }}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Tokopaedi') selected @endif value="Tokopaedi">Tokopaedi</option>
            <option @if($selected == 'Bukulapuk') selected @endif value="Bukulapuk">Bukulapuk</option>
            <option @if($selected == 'TokoBagas') selected @endif value="TokoBagas">TokoBagas</option>
            <option @if($selected == 'E Commurz') selected @endif value="E Commurz">E Commurz</option>
            <option @if($selected == 'Blublu') selected @endif value="Blublu">Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Obat') selected @endif value="Obat">Obat</option>
            <option @if($selected == 'Alkes') selected @endif value="Alkes">Alkes</option>
            <option @if($selected == 'Matkes') selected @endif value="Matkes">Matkes</option>
            <option @if($selected == 'Umum') selected @endif value="Umum">Umum</option>
            <option @if($selected == 'ATK') selected @endif value="ATK">ATK</option>
        </select>
    </div>

    <div class="form-group">
        <label for="kategori_item_id">Kategori</label>
        <select name="kategori_item_id" id="kategori_item_id" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($kategori_items as $kategori)
                <option value="{{ $kategori->id }}" {{ isset($item->kategori_item_id) && $item->kategori_item_id == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Foto (Opsional)</label>
        <input type="file" class="form-control" name="foto" id="foto-input">
        <div class="mt-2">
            <img id="preview-foto"
                 src="{{ $method == 'edit' && !empty($item->foto) ? asset('storage/' . $item->foto) : asset('images/no_image.png') }}"
                 alt="Preview Foto"
                 width="100">
        </div>
    </div>

    <button class="btn btn-primary mt-3">Submit</button>
</form>

<!-- Script Preview Foto -->
<script>
    document.getElementById('foto-input').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('preview-foto').src = URL.createObjectURL(file);
        }
    });
</script>
