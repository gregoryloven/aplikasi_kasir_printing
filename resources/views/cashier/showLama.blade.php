@extends('layout.sbadmin2')

@section('title')
    Detail Produk
@endsection




@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <!-- Judul atau informasi tambahan jika diperlukan -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No Nota</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $data->no_nota }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Qty</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_detail as $d)
                    <tr>
                        <td>{{ $d['nama'] }}</td>
                        <td>{{ $d['qty'] }}</td>
                        <td>Rp. {{ number_format($d['sub_total'], 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td>Total</td>
                        <td>Rp. {{ number_format($data->grand_total, 0) }}</td>
                    </tr>
                    <tr>
                        <td>Bayar</td>
                        <td>Rp. {{ number_format($data->bayar, 0) }}</td>
                    </tr>
                    <tr>
                        <td>Kembali</td>
                        <td>Rp. {{ number_format($data->kembali, 0) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


    </div>
</div>

@endsection

@section('javascript')
<script>

</script>

@endsection