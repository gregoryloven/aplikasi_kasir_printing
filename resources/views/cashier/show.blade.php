@extends('layout.sbadmin2')

@section('title')
    Detail Produk
@endsection

@section('content')

<div class="card invoice">
    <div class="card-header p-4 p-md-5 border-bottom-0 bg-primary text-white">
        <div class="row justify-content-between align-items-center">
            <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-start">
                <!-- Invoice branding-->
                <img class="invoice-brand-img rounded-circle mb-4">
                <div class="h2 text-white mb-0">Detail Penjualan</div>
            </div>
            <div class="col-12 col-lg-auto text-center text-lg-end">
                <!-- Invoice details-->
                <!-- <div class="h3 text-white">Nota</div> -->
                #{{ $data->no_nota }}
                <br>
                {{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}
                <br>
                {{ $data->user->name }}
            </div>
        </div>
    </div>
    <div class="card-body p-4 p-md-5">
        <!-- Invoice table-->
        <div class="table-responsive">
            <table class="table table-borderless mb-0">
                <thead class="border-bottom">
                    <tr class="small text-uppercase text-muted">
                        <th width="10%">No</th>
                        <th width="40%" scope="col">Nama Produk</th>
                        <th width="20%" class="text-end" scope="col">Qty</th>
                        <th width="25%"class="text-end" scope="col">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach($data_detail as $d)
                    @php $i += 1; @endphp
                    <!-- Invoice item 1-->
                    <tr class="border-bottom">
                        <td>@php echo $i; @endphp</td>
                        <td><div class="fw-bold">{{ $d['nama'] }}</div></td>
                        <td class="text-end fw-bold">{{ $d['qty'] }}</td>
                        <td class="text-end fw-bold">Rp. {{ number_format($d['sub_total'], 0) }}</td>
                    </tr>
                    @endforeach
                    <!-- Invoice subtotal-->
                    <tr>
                        <td class="text-end pb-0" colspan="3"><div class="text-uppercase small fw-700 text-muted"> Total: </div></td>
                        <td class="text-end pb-0"><div class="h5 mb-0 fw-700">Rp. {{ number_format($data->grand_total, 0) }}</div></td>
                    </tr>
                    <!-- Invoice tax column-->
                    <tr>
                        <td class="text-end pb-0" colspan="3"><div class="text-uppercase small fw-700 text-muted">Bayar:</div></td>
                        <td class="text-end pb-0"><div class="h5 mb-0 fw-700">Rp. {{ number_format($data->bayar, 0) }}</div></td>
                    </tr>
                    <!-- Invoice total-->
                    <tr>
                        <td class="text-end pb-0" colspan="3"><div class="text-uppercase small fw-700 text-muted">Kembali:</div></td>
                        <td class="text-end pb-0"><div class="h5 mb-0 fw-700 text-green">Rp. {{ number_format($data->kembali, 0) }}</div></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection