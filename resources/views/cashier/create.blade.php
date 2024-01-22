@extends('layout.sbadmin2')

@section('title')
    Daftar Penjualan
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<h2>Transaksi Penjualan</h2>

<form method="POST" action="{{route('cashier.store')}}">
    @csrf
    <div class="row mb-3 mt-2">
        <div class="col-3">
            <label for="exampleInputPassword1">Nama Produk</label>
        </div>
        <div class="col-4">
            <select name="produk" id="produk" style="width: 100%;" class="form-select">
                <option value="">Pilih Produk</option>
                @foreach($products as $p)
                        <option value="{{ $p->id }}"
                             data-harga="{{ number_format($p->harga_jual, 0, ',', '.') }}"
    
                             data-kode = "{{ $p->kode}}"
                             data-id = "{{$p->id}}"
                        > 
                        <?php echo $p->kode ?> - <?php echo $p->nama ?> </option>
                @endforeach   
            </select>
        </div>
  
    </div>
   
    <input type="hidden" name="products_data" id="productsDataInput" value="">


<div class="card shadow mb-4">
    <div class="card-header py-3"></div>
    <div class="card-body">

    <table id="nota" class="table table-hover table-condensed">
                        <thead>
                        <tr>
                            <th style="width:10%">No</th>
                            <th style="width:15%">Kode</th>
                            <th style="width:15%">Nama</th>
                            <th style="width:15%" class="cell-harga">Harga</th>
                            <th style="width:15%">Jumlah</th>
                            <th style="width:15%" class="cell-subtotal">Subtotal</th>
                            <th width="10%"><i class="fa fa-cog"></i></th>
                        </tr>
                        </thead>
                        <tbody name="tableProduct" id="tableBody">
                        </tbody>
                    </table>


<div class="row mt-4">
<div class="col-6 mr-2 ml-2" style="background: green; height:100px">
    <h2 class="mt-4" style="text-align: center; color: white;" id="h2-total">Total : Rp.0</h2>
    <!-- <label id="label-terbilang">Terbilang : nol Rupiah </label> -->

</div>

<div class="col-5" style="float: right;">

            <!-- Untuk ambil data total dan kembalian -->
            <input type="hidden" name="total" id="totalInput" value="">
            <input type="hidden" name="kembalian" id="kembalianInput" value="">


           <div class="row mb-3">
                <div class="col-4">
                <label
                  for="colFormLabelSm"
                  className="col-sm-4 col-form-label col-form-label-sm"
                >
                  Total
                </label>
                </div>
                <div class="col-6">
                <input disabled type="text" class="form-control" id="dengan-rupiah" name="total" style="width: 65%; margin-left: 90px;" value="">

                </div>
           </div>

           <div class="row mb-3">
                <div class="col-4">
                <label
                  for="colFormLabelSm"
                  className="col-sm-4 col-form-label col-form-label-sm"
                >
                  Diterima
                </label>
                </div>
                <div class="col-6">
                <input type="text" class="form-control input-diterima" id="bayar" name="bayar" style="width: 65%; margin-left: 90px;" onchange="hitungKembalian(this.value)">

                </div>
           </div>
           <div class="row mb-3">
                <div class="col-4">
                <label
                  for="colFormLabelSm"
                  className="col-sm-4 col-form-label col-form-label-sm"
                >
                  Kembali
                </label>
                </div>
                <div class="col-6">
                <input type="text" disabled class="form-control" id="kembali" name="kembali" style="width: 65%; margin-left: 90px;" value="">

                </div> 
           </div>

           <button type="submit" class="btn btn-info" style="float:right">Submit</button>

       
           </div>
      
    </div>
</div>
</div>
</form>

                  






@endsection

@section('javascript')
<script>

var products_data = []; 


document.addEventListener("DOMContentLoaded", function () {

    console.log("DOM content loaded");
    document.getElementById('produk').addEventListener('change', handleSelectChange);

    var total = 0;


        function handleSelectChange() {
            
            console.log('a')

            var selectedProduct = document.getElementById('produk');
            var selectedProductName = selectedProduct.options[selectedProduct.selectedIndex].text;
            var selectedProductPrice = selectedProduct.options[selectedProduct.selectedIndex].dataset.harga;
            var selectedProductCode = selectedProduct.options[selectedProduct.selectedIndex].dataset.kode;
            var selectedProductValue = selectedProduct.options[selectedProduct.selectedIndex].value;

            var selectedProductId = selectedProduct.options[selectedProduct.selectedIndex].dataset.id;

            if(selectedProductValue != ''){

            // Mendapatkan referensi tbody dari tabel
            var tableBody = document.getElementById('tableBody');

            // Membuat baris baru
            var newRow = tableBody.insertRow();
            
            // Menambahkan sel-sel ke dalam baris
            var cellNo = newRow.insertCell(0);
            var cellKode = newRow.insertCell(1);
            var cellNama = newRow.insertCell(2);
            var cellHarga = newRow.insertCell(3);
            var cellJumlah = newRow.insertCell(4);
            var cellSubtotal = newRow.insertCell(5);
            var cellActions = newRow.insertCell(6);

            // Menambahkan data ke dalam sel-sel
            cellNo.innerHTML = tableBody.rows.length; // Nomor baris
            cellKode.innerHTML =  selectedProductCode; // Ganti dengan kode produk yang sesuai
            cellNama.innerHTML = selectedProductName; // Nama produk dari select option
            cellHarga.innerHTML = '<input type="text" disabled class="form-control input-harga" name="harga[]" value="' + selectedProductPrice + '">'
            cellJumlah.innerHTML = '<input type="text" class="form-control input-jumlah" name="jumlah[]">'; // Input jumlah
            cellSubtotal.innerHTML = '<input type="text" disabled class="form-control input-subtotal" name="subtotal[]">';
            cellActions.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button>'; // Tombol hapus
            
        }
       
        }

  

    function getDataArray (inputElement){
        
        var selectedProduct = document.getElementById('produk');
        var selectedProductName = selectedProduct.options[selectedProduct.selectedIndex].text;
        var selectedProductPrice = selectedProduct.options[selectedProduct.selectedIndex].dataset.harga;
        var selectedProductCode = selectedProduct.options[selectedProduct.selectedIndex].dataset.kode;
        var selectedProductValue = selectedProduct.options[selectedProduct.selectedIndex].value;

        var row = inputElement.closest('tr');

        var cellHarga = row.querySelector('td input.input-harga');

        var hargaValue = cellHarga.value;
        
        hargaValue = hargaValue.replace(/[^0-9]/g, '');

        var hargaValue2 = formatNumber(hargaValue);

        var cellSubtotal = row.querySelector('td input.input-subtotal');

        var cellJumlah = row.querySelector('td input.input-jumlah');


    // Dapatkan harga dan jumlah
    var harga = parseFloat(hargaValue.value); // Ambil nilai dari input harga
    var jumlah = parseFloat(cellJumlah.value) || 0; // Jumlah yang diisi pengguna

    // Hitung subtotal
    var subtotal = hargaValue * jumlah;

    var productData = {
                kode: selectedProductCode,
                nama: selectedProductName,
                harga: selectedProductPrice,
                jumlah: jumlah, // Isi dengan nilai jumlah yang sesuai
                subtotal: subtotal // Isi dengan nilai subtotal yang sesuai
    };


    // Pengecekan apakah data dengan nama yang sama sudah ada
    var existingProductIndex = products_data.findIndex(function (product) {
        return product.nama === selectedProductName;
    });

    if (existingProductIndex !== -1) {
        // Jika data dengan nama yang sama sudah ada, ganti data yang ada
        products_data[existingProductIndex] = productData;
    } else {
        // Jika tidak, tambahkan data baru
        products_data.push(productData);
    }
     console.log(products_data);

    }




    function handleJumlahInput(inputElement) {

    // Dapatkan elemen baris (tr) terkait dengan input jumlah
    var row = inputElement.closest('tr');

    // console.log(row)

    var cellHarga = row.querySelector('td input.input-harga');
    var hargaValue = cellHarga.value;

     
    hargaValue = hargaValue.replace(/[^0-9]/g, '');


    var hargaValue2 = formatNumber(hargaValue);



    var cellSubtotal = row.querySelector('td input.input-subtotal');

    var cellJumlah = row.querySelector('td input.input-jumlah');


    // Dapatkan harga dan jumlah
    var harga = parseFloat(hargaValue.value); // Ambil nilai dari input harga
    var jumlah = parseFloat(cellJumlah.value) || 0; // Jumlah yang diisi pengguna

    // Hitung subtotal
    var subtotal = hargaValue * jumlah;
    // cellSubtotal.value = subtotal;


    cellSubtotal.value = subtotal.toLocaleString('id-ID');

    updateTotal();


    document.addEventListener('input', function (event) {
    if (event.target.classList.contains('input-jumlah')) {
       
        getDataArray(event.target);
    }
});


}

function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }



document.addEventListener('input', function (event) {
    if (event.target.classList.contains('input-jumlah')) {
        handleJumlahInput(event.target);
        getDataArray(event.target);
    }
});

 

      /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('dengan-rupiah');
    
        dengan_rupiah.addEventListener('keyup', function(e)
        {
            dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
        });
    
    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }



    
    function terbilangRupiah(angka) {
    const bilangan = [
        "", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh",
        "Sebelas", "Dua Belas", "Tiga Belas", "Empat Belas", "Lima Belas", "Enam Belas", "Tujuh Belas", "Delapan Belas", "Sembilan Belas"
    ];

    const ribuan = ["", "Seribu", "Dua Ribu", "Tiga Ribu", "Empat Ribu", "Lima Ribu", "Enam Ribu", "Tujuh Ribu", "Delapan Ribu", "Sembilan Ribu"];

    function konversiSatuan(nilai) {
        if (nilai < 20) {
            return bilangan[nilai];
        } else if (nilai < 100) {
            return `${bilangan[Math.floor(nilai / 10)]} Puluh ${bilangan[nilai % 10]}`;
        } else {
            return `${bilangan[Math.floor(nilai / 100)]} Ratus ${konversiSatuan(nilai % 100)}`;
        }
    }

    if (angka === 0) {
        return "Nol Rupiah";
    } else {
        const angkaString = angka.toString();
        const panjangAngka = angkaString.length;

        if (panjangAngka > 9) {
            return "Angka terlalu besar untuk dikonversi.";
        } else {
            let hasilKonversi = "";
            let posisiRibuan = panjangAngka - 1;

            for (let i = 0; i < panjangAngka; i++) {
                const digit = parseInt(angkaString[i], 10);

                if (digit !== 0) {
                    hasilKonversi += `${konversiSatuan(digit)} ${ribuan[posisiRibuan]} `;
                }

                posisiRibuan--;
            }

            return `Rp. ${hasilKonversi.trim()}`;
        }
    }
}


});

   // Fungsi untuk menghapus baris dari tabel
   function removeRow(button) {
    
    var row = button.parentNode.parentNode;
    var productName = row.querySelector('td:nth-child(3)').textContent; // Assuming the product name is in the third column

    // Find the index of the product in products_data
    var productIndex = products_data.findIndex(function(product) {
        return product.nama === productName;
    });

    if (productIndex !== -1) {
        // Remove the product from products_data
        products_data.splice(productIndex, 1);
    }

    // Remove the row from the table
    row.parentNode.removeChild(row);

    updateTotal();


    console.log(products_data);

    }


function hitungKembalian(bayar){

updateTotal();


    var kembali = "";

    bayar = bayar.replace(/[^0-9]/g, '');

    kembali = bayar - total; 

    var kembalian = document.getElementById('kembali');

    kembalian.value = kembali.toLocaleString('id-ID'); 

      // Set the value of the hidden kembalian input field
    var kembalianInput = document.getElementById('kembalianInput');
    kembalianInput.value = kembali;

    // Set the value of the hidden total input field
    var totalInput = document.getElementById('totalInput');
    totalInput.value = total;

    // Set the value of the hidden products_data input field
    document.getElementById('productsDataInput').value = JSON.stringify(products_data);

}

function updateTotal() {
        total = 0;

        // Ambil semua elemen subtotal
        var subtotalElements = document.querySelectorAll('.input-subtotal');


        subtotalElements.forEach(function (subtotalElement) {
            
            subtotalElement = subtotalElement.value.replace(/[^0-9]/g, '');

            total += parseFloat(subtotalElement) || 0;
        });

        // Update elemen input total
        var dengan_rupiah = document.getElementById('dengan-rupiah');
        dengan_rupiah.value = total.toLocaleString('id-ID');

        var h2Total = document.getElementById('h2-total');
        h2Total.textContent = 'Total: Rp. ' +  total.toLocaleString('id-ID'); // Ubah sesuai kebutuhan

    // var terbilang = document.getElementById('label-terbilang');

    }


    $(".input-diterima").on("input", function() {
        let inputValueDiterima = $(this).val();

        inputValueDiterima = inputValueDiterima.replace(/[^0-9]/g, '');

        let formattedValueDiterima = formatNumber(inputValueDiterima);

        $(this).val(formattedValueDiterima);
    });

    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }


</script>

@endsection