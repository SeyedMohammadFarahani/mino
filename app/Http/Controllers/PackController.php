<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PackController extends Controller
{
    public function save(Request $request)
    {
        //rules Validation
        $rules = [
            'name' => ['required', 'unique:packs'],
            'unit' => 'required',
            'price' => 'required',
        ];

        //Error Messages Validation
        $messages = [
            'name.required' => 'لطفا نام بسته بندی را وارد کنید',
            'name.unique' => 'این بسته بندی قبلا وارد شده است',
            'unit.required' => 'لطفا واحد بسته بندی را وارد کنید',
            'price.required' => 'لطفا قیمت واحد بسته بندی را وارد کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //insert database
        $insertDetails = [
            'name' => $request->get('name'),
            'unit' => $request->get('unit'),
            'price' => $request->get('price'),
        ];

        DB::table('packs')->insert($insertDetails);

        //alert message
        flash($request, 'بسته بندی با موفقیت اضافه شد', 'success');

        return redirect(route('packs.show'));
    }

    public function update($id, Request $request)
    {
        //rules Validation
        $rules = [
            'name' => ['required'],
            'unit' => 'required',
            'price' => 'required',
        ];

        //Error Messages Validation
        $messages = [
            'name.required' => 'لطفا نام بسته بندی را وارد کنید',
            'unit.required' => 'لطفا واحد بسته بندی را وارد کنید',
            'price.required' => 'لطفا قیمت واحد بسته بندی را وارد کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //update database
        $updateDetails = [
            'name' => $request->get('name'),
            'unit' => $request->get('unit'),
            'price' => $request->get('price'),
        ];

        DB::table('packs')
            ->where('id', '=', $id)
            ->update($updateDetails);

        //alert message
        flash($request, 'تغییرات با موفقیت اعمال شد', 'success');

        return redirect(route('packs.show'));
    }

    public function deletePack($id, Request $request)
    {
        DB::table('packs')->where('id', '=', $id)->delete();

        //alert message
        flash($request, 'بسته بندی با موفقیت حذف شد', 'danger');

        return redirect(route('packs.show'));
    }

    public function deleteAll(Request $request)
    {
        $selectedPacks = $request->input('packs');

        if ($selectedPacks == null) {
            flash($request, 'لطفا ابتدا موارد مد نظر خود را انتخاب کنید', 'danger');
            return redirect(route('packs.show'));
        }

        foreach ($selectedPacks as $pack) {
            DB::table('packs')->where('id', '=', $pack)->delete();
        }

        //alert message
        flash($request, 'بسته بندی ها با موفقیت حذف شدند', 'danger');

        return redirect(route('packs.show'));
    }
}
