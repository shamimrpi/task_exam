<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    //
    public function create(){
        
        return view('transaction.create');
    }

    public function store(Request $request){
        try {
            // dd($request->all());
            if($request->transaction_type == WITHDRAWAL){
                // dd('ok');
                $friday = date("Y-m-d", strtotime("Friday"));
                if($friday){
                    $deposite = Transaction::where('user_id',Auth::id())->where('transaction_type',DEPOSITE)->get();
                    $widtdrawal = Transaction::where('user_id',Auth::id())->where('transaction_type',WITHDRAWAL)->get();
                    $deposite_balance = $deposite->sum('amount');
                    $widtdrawal_balance = $widtdrawal->sum('amount') + $widtdrawal->sum('fee');
                    $exist_balance = $deposite_balance - $widtdrawal_balance;
                    $fee_amount = 0;
                    $required_balance = $request->amount + $fee_amount;
                    if($required_balance <=$exist_balance){
                        $transaction = new Transaction();
                        $transaction->user_id = Auth::id();
                        $transaction->amount = $request->amount;
                        $transaction->fee = $fee_amount;
                        $transaction->date = date("Y-m-d");
                        $transaction->transaction_type = $request->transaction_type;
                        $transaction->save();
                    }
                }
                elseif(Auth::user()->account_type == BUSINESS){
                    $deposite = Transaction::where('user_id',Auth::id())->where('transaction_type',DEPOSITE)->get();
                    $widtdrawal = Transaction::where('user_id',Auth::id())->where('transaction_type',WITHDRAWAL)->get();
                    $deposite_balance = $deposite->sum('amount');
                    $widtdrawal_balance = $widtdrawal->sum('amount') + $widtdrawal->sum('fee');
                    $exist_balance = $deposite_balance - $widtdrawal_balance;
                    $fee_amount = $request->amount * 15/1000;
                    $required_balance = $request->amount + $fee_amount;
                    if($required_balance <=$exist_balance){
                        $transaction = new Transaction();
                        $transaction->user_id = Auth::id();
                        $transaction->amount = $request->amount;
                        $transaction->fee = $fee_amount;
                        $transaction->date = date("Y-m-d");
                        $transaction->transaction_type = $request->transaction_type;
                        $transaction->save();
                    }
                   
                    // $transaction->fee = 
                }
                elseif(Auth::user()->account_type == INDIVIDUAL){
                    $deposite = Transaction::where('user_id',Auth::id())->where('transaction_type',DEPOSITE)->get();
                    $widtdrawal = Transaction::where('user_id',Auth::id())->where('transaction_type',WITHDRAWAL)->get();
                    $deposite_balance = $deposite->sum('amount');
                    $widtdrawal_balance = $widtdrawal->sum('amount') + $widtdrawal->sum('fee');
                    $exist_balance = $deposite_balance - $widtdrawal_balance;
                    $fee_amount = $request->amount * 25/1000;
                    $required_balance = $request->amount + $fee_amount;
                    if($required_balance <=$exist_balance){
                        $transaction = new Transaction();
                        $transaction->user_id = Auth::id();
                        $transaction->amount = $request->amount;
                        $transaction->fee = $fee_amount;
                        $transaction->date = date("Y-m-d");
                        $transaction->transaction_type = $request->transaction_type;
                        $transaction->save();
                    }
                   
                    // $transaction->fee = 
                }
                elseif(){

                }
            }else{
                $transaction = new Transaction();
                $transaction->user_id = Auth::id();
                $transaction->amount = $request->amount;
                $transaction->transaction_type = $request->transaction_type;
                $transaction->save(); 
            }
            
           
            
            return redirect()->route('transaction.index')->with('success','User created successfylly');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
        
    }
}
