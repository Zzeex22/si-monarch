<form action="{{ route('proyek.store') }}" method="POST">
    @csrf
    <div class="form-container">
        <div class="grid-2">
            <div class="form-group"><label>Nama Proyek</label><input type="text" name="nama_proyek" required></div>
            <div class="form-group"><label>Client / Klien</label><input type="text" name="klien" required></div>
        </div>
        
        <div class="form-group">
            <label>Pilih Kontrak</label>
            <select name="kontrak_id" style="width:100%; padding:10px; background:#282936; color:#fff; border-radius:5px;">
                @foreach($kontrakList as $k)
                    <option value="{{ $k->id }}">{{ $k->nomor_kontrak }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group"><label>Anggaran</label><input type="number" name="anggaran"></div>
        <button type="submit" class="btn-submit">Simpan Proyek</button>
    </div>
</form>