<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function save(Request $request)
    {

        //rules Validation
        $rules = [
            'product_code' => 'required',
            'weight' => 'required',
            'date' => 'required',
        ];

        //Error Messages Validation
        $messages = [
            'product_code.required' => 'لطفا کد محصول را وارد کنید',
            'weight.required' => 'لطفا وزن محصول را وارد کنید',
            'date.required' => 'لطفا تاریخ تولید محصول را وارد کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        $product = DB::table('products')->where('code', '=', $request->get('product_code'))->get()->first();

        $finalPrice = $product->price;


        //insert database
        $insertDetails = [
            'product_code' => $request->get('product_code'),
            'product_name' => $request->get('product_name'),
            'weight' => $request->get('weight'),
            'date' => $request->get('date'),
            'finalPrice' => $finalPrice,

        ];

        DB::table('transactions')->insert($insertDetails);

        //alert message
        flash($request, 'تراکنش با موفقیت اضافه شد', 'success');

        return redirect(route('transactions.show'));
    }

    public function update($id, Request $request)
    {
        //rules Validation
        $rules = [
            'product_code' => 'required',
            'weight' => 'required',
            'soldPrice' => 'required',
        ];

        //Error Messages Validation
        $messages = [
            'product_code.required' => 'لطفا کد محصول را وارد کنید',
            'weight.required' => 'لطفا وزن محصول را وارد کنید',
            'soldPrice.required' => 'لطفا فروش محصول را وارد کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        $product = DB::table('products')->where('code', '=', $request->get('product_code'))->get()->first();

        $finalPrice = $product->price;

        $profit = $request->get('weight') * ($request->get('soldPrice') - $finalPrice);

        //update database
        $updateDetails = [
            'product_code' => $request->get('product_code'),
            'product_name' => $request->get('product_name'),
            'weight' => $request->get('weight'),
            'finalPrice' => $finalPrice,
            'soldPrice' => $request->get('soldPrice'),
            'profit' => $profit,
        ];

        DB::table('transactions')
            ->where('id', '=', $id)
            ->update($updateDetails);

        //alert message
        flash($request, 'تغییرات با موفقیت اعمال شد', 'success');

        return redirect(route('transactions.show'));
    }

    public function findProduct($code, Request $request)
    {
        $product = DB::table('products')->where('code', '=', $code)->get()->first();
        $product_name = $product->name;
        $finalPrice = number_format($product->price, 4, '.', ',');
        $bom = $product->bom;

        return response()->json(['product_name' => $product_name, 'finalPrice' => $finalPrice, 'bom' => $bom]);
    }

    public function showSearchTransaction()
    {
        $transactions = null;
        return view('transaction/search_transaction', compact('transactions'));
    }

    public function showSearchResult(Request $request)
    {
        $allTransactions = DB::table('transactions')->get();
        $transactions = collect();

        $firsDate = $request->get('firstDateHidden');
        $lastDate = $request->get('lastDateHidden');

        foreach ($allTransactions as $transaction) {
            if (($transaction->date) >= $firsDate and ($transaction->date) <= $lastDate) {
                $transactions->push($transaction);
            }
        }


        return view('transaction/search_transaction', compact('transactions'));
    }

    public function deleteTransaction($id, Request $request)
    {
        DB::table('transactions')->where('id', '=', $id)->delete();

        //alert message
        flash($request, 'تراکنش با موفقیت حذف شد', 'danger');

        return redirect(route('transactions.show'));
    }

    public function deleteAll(Request $request)
    {
        $selectedTransactions = $request->input('transactions');

        if ($selectedTransactions == null) {
            flash($request, 'لطفا ابتدا موارد مد نظر خود را انتخاب کنید', 'danger');
            return redirect(route('transactions.show'));
        }

        foreach ($selectedTransactions as $transactions) {
            DB::table('processes')->where('id', '=', $transactions)->delete();
        }

        //alert message
        flash($request, 'تراکنش ها با موفقیت حذف شدند', 'danger');

        return redirect(route('transactions.show'));
    }

    public function downloadBom($bom)
    {
        return response()->download(storage_path($bom));
    }
}
