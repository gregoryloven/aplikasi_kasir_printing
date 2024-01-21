@extends('layout.sbadmin2')

@section('title')
    Daftar Transaksi Penjualan
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

<a href="{{url('addTransaction')}}">
    <button type="button" class="btn btn-info float-left"><i class="fa fa-plus-circle"></i> Tambah Penjualan Baru</button>
</a><br><br>

<div class="card shadow mb-4">
    <div class="card-header py-3">Daftar Penjualan</div>
        <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr style="text-align: center;">
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                @php $i = 0; @endphp
                    @foreach($data as $d)
                    @php $i += 1; @endphp
                    <tr style="text-align: center;">
                        <td>@php echo $i; @endphp</td>
                        <td st>{{$d->no_nota}}</td>
                        <td st>{{ \Carbon\Carbon::parse($d->tanggal)->format('d-m-Y') }}</td>
                        <td st>
                        Rp. {{ number_format($d->grand_total, 0) }}    
                        </td>
                        <td>
                        <a class="btn btn-icon btn-info" data-id="{{ $d->id }}" 
                                        href="{{route('cashier.show', $d->id)}} ">
                                        <i class="fas fa-search"></i>
                                    </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection