<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Transaction::all();
      
        return view('cashier.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Transaction::all();
        $products = Product::all(); 
        return view('cashier.create', compact('data', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Transaction;
        
        $tanggalHariIni = Carbon::now();
        $formatTanggal = $tanggalHariIni->format('dmY');

        // $total = $request->input('total');
        // $kembalian = $request->input('kembalian');
        $data->user_id = Auth::user()->id;
        $data->no_nota = Transaction::generate_code($formatTanggal);
        $data->tanggal = Carbon::now();
        $data->grand_total = $request->input('total');
        $data->bayar = str_replace('.', '',$request->get('bayar'));
        $data->kembali = $request->input('kembalian');

        // Memeriksa apakah nominal bayar lebih kecil dari grand total
        if ($data->bayar < $data->grand_total) {
            return back()->with('error', 'Nominal bayar tidak mencukupi');
        }

        $data->save(); 

        $transactionId = $data->id;

        $products = json_decode($request->get('products_data'), true);

        foreach ($products as $index => $p) {

            $id_product = Product::where('kode','=', $p['kode'])->first(); 

            $transactionDetail = new TransactionDetail;
            $transactionDetail->transaction_id = $transactionId;
            $transactionDetail->product_id = $id_product->id;
            $transactionDetail->qty = $p['jumlah']; 
            $transactionDetail->sub_total = $p['subtotal']; 

            $transactionDetail->save();
        }
        

        return redirect()->route('cashier.index')->with('success', 'Data Penjualan berhasil ditambah');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = Transaction::select('transactions.*')
        ->where('transactions.id', '=', $id)
        ->first();
    

        $data_detail = Transaction::select('transaction_details.*', 'products.nama')
        ->leftJoin('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
        ->leftJoin('products', 'products.id', '=', 'transaction_details.product_id')
        ->where('transactions.id', '=', $id)
        ->get();

        return view('cashier.show',["data"=>$data, "data_detail"=> $data_detail]);



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
