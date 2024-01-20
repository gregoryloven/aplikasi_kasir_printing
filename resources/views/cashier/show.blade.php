@extends('layout.sbadmin2')

@section('title')
    Detail Produk
@endsection




@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3"></div>
    <div class="card-body">
        <div class="table-responsive">
            <p>No Nota  <b>{{$data->no_nota}}</b></p>
            <p> Tanggal 
           {{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}
            </p>

            @foreach($data_detail as $d)
            <ul>
                <li>{{$d['nama']}} - {{$d['qty']}} - Rp. {{ number_format($d['sub_total'], 2) }}</li>
            </ul>
            @endforeach

            <p>Total   Rp. {{ number_format($data->grand_total, 2) }}  </p>
            <p>Bayar   Rp. {{ number_format($data->bayar, 2) }}  </p>
            <p>Kembali   Rp. {{ number_format($data->kembali, 2) }}  </p>



        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>

</script>

@endsection