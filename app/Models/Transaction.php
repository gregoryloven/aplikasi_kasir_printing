<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class, "transaction_id", "id");
    }


    
    public static function generate_code( $date){

        $prefix = "TR".$date;

    
        $transaction = Transaction::where("no_nota", "like", $prefix . "%")->orderBy("no_nota", "DESC")->first();
        $number = 1;

        if ($transaction != null) {
            $number = (int)substr($transaction->code, 12) + 1;
        }

        $code = $prefix . str_pad($number, 3, 0, STR_PAD_LEFT);
        return $code;
    }
}
