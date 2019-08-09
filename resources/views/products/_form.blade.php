<div class="row">
    <div class="col-md-6">
        <div class="form-group col-md-12 {{ $errors->has('code') ? ' has-error' : '' }}">
            <label for="" class="control-label">Kode Produk</label>
            {!! Form::text('code', null, ['class'=>'form-control']) !!}
            {!! $errors->first('code', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group col-md-12 {{ $errors->has('code') ? ' has-error' : '' }}">
            <label for="" class="control-label">Nama Produk</label>
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group col-md-12 {{ $errors->has('stock') ? ' has-error' : '' }}">
            <label for="" class="control-label">Stok</label>
            {!! Form::number('stock', null, ['class'=>'form-control']) !!}
            {!! $errors->first('stock', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group col-md-12 {{ $errors->has('price') ? ' has-error' : '' }}">
            {!! Form::label('price', 'Harga', ['class'=>'control-label']) !!}
            <div class="input-group">
                <span class="input-group-addon">Rp.</span>
                {!! Form::text('price', null, ['class'=>'form-control', 'onkeyup' => 'terbilang()']) !!}
            </div>
            <label id="terbilang"></label>
            {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 marginRow">
        <div class="form-group col-md-12 {{ $errors->has('stock') ? ' has-error' : '' }}">
            <label for="" class="control-label">Kategori</label>
            <select name="category_id" class="select2 form-control" id="cari" style="width: 100%;">
            </select>
            {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-6 marginRow">
        <div class="form-group col-md-12">
            <label for="" class="control-label">Foto</label>
            <input type="file" name="photo" class="form-control" id="photo" accept='image/jpeg , image/jpg, image/gif, image/png'>
        </div>
    </div>
</div>

<div class="form-group col-md-12">
    <label for="" class="control-label">Deskripsi</label>
    {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description']) !!}
</div>

<div class="form-group col-md-12">
    {!! Form::submit('Simpan', ['class'=>'btn btn-primary']) !!}
</div>

@push('scripts')
<script type="text/javascript">
    $('#cari').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/search/products',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
<script charset="utf-8" type="text/javascript">
    function terbilang() {
        var bilangan = document.getElementById("price").value;
        var kalimat = "";
        var angka = new Array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
        var kata = new Array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan');
        var tingkat = new Array('', 'Ribu', 'Juta', 'Milyar', 'Triliun');
        var panjang_bilangan = bilangan.length;

        /* pengujian panjang bilangan */
        if (panjang_bilangan > 15) {
            kalimat = "Diluar Batas";
        } else {
            /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
            for (i = 1; i <= panjang_bilangan; i++) {
                angka[i] = bilangan.substr(-(i), 1);
            }

            var i = 1;
            var j = 0;

            /* mulai proses iterasi terhadap array angka */
            while (i <= panjang_bilangan) {
                subkalimat = "";
                kata1 = "";
                kata2 = "";
                kata3 = "";

                /* untuk Ratusan */
                if (angka[i + 2] != "0") {
                    if (angka[i + 2] == "1") {
                        kata1 = "Seratus";
                    } else {
                        kata1 = kata[angka[i + 2]] + " Ratus";
                    }
                }

                /* untuk Puluhan atau Belasan */
                if (angka[i + 1] != "0") {
                    if (angka[i + 1] == "1") {
                        if (angka[i] == "0") {
                            kata2 = "Sepuluh";
                        } else if (angka[i] == "1") {
                            kata2 = "Sebelas";
                        } else {
                            kata2 = kata[angka[i]] + " Belas";
                        }
                    } else {
                        kata2 = kata[angka[i + 1]] + " Puluh";
                    }
                }

                /* untuk Satuan */
                if (angka[i] != "0") {
                    if (angka[i + 1] != "1") {
                        kata3 = kata[angka[i]];
                    }
                }

                /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
                if ((angka[i] != "0") || (angka[i + 1] != "0") || (angka[i + 2] != "0")) {
                    subkalimat = kata1 + " " + kata2 + " " + kata3 + " " + tingkat[j] + " ";
                }

                /* gabungkan variabe sub kalimat (untuk Satu blok 3 angka) ke variabel kalimat */
                kalimat = subkalimat + kalimat;
                i = i + 3;
                j = j + 1;
            }

            /* mengganti Satu Ribu jadi Seribu jika diperlukan */
            if ((angka[5] == "0") && (angka[6] == "0")) {
                kalimat = kalimat.replace("Satu Ribu", "Seribu");
            }
        }
        document.getElementById("terbilang").innerHTML = kalimat;
    }
</script>
@endpush
{!! Form::close() !!}