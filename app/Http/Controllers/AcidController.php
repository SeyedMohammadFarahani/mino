<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AcidController extends Controller
{
    public function save(Request $request)
    {
        //rules Validation
        $rules = [
            'name' => ['required', 'unique:acids'],
            'price' => 'required',
        ];

        //Error Messages Validation
        $messages = [
            'name.required' => 'لطفا نام ماده کمک فرآیند را وارد کنید',
            'name.unique' => 'این ماده قبلا وارد شده است',
            'price.required' => 'لطفا قیمت ماده کمک فرآیند را وارد کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //insert database
        $insertDetails = [
            'name' => $request->get('name'),
            'price' => $request->get('price'),
        ];

        DB::table('acids')->insert($insertDetails);

        //alert message
        flash($request, 'ماده کمک فرآیند با موفقیت اضافه شد', 'success');

        return redirect(route('acids.show'));
    }

    public function update($id, Request $request)
    {
        //rules Validation
        $rules = [
            'name' => ['required'],
            'price' => 'required',
        ];

        //Error Messages Validation
        $messages = [
            'name.required' => 'لطفا نام ماده کمک فرآیند را وارد کنید',
            'price.required' => 'لطفا قیمت ماده کمک فرآیند را وارد کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //insert database
        $updateDetails = [
            'name' => $request->get('name'),
            'price' => $request->get('price'),
        ];

        //update database
        DB::table('acids')
            ->where('id', '=', $id)
            ->update($updateDetails);

        //alert message
        flash($request, 'تغییرات با موفقیت اعمال شد', 'success');

        return redirect(route('acids.show'));
    }

    public function deleteAcid($id, Request $request)
    {
        DB::table('acids')->where('id', '=', $id)->delete();

        //alert message
        flash($request, 'ماده کمک فرآیند با موفقیت حذف شد', 'danger');

        return redirect(route('acids.show'));
    }

    public function deleteAll(Request $request)
    {
        $selectedAcids = $request->input('acids');

        if ($selectedAcids == null) {
            flash($request, 'لطفا ابتدا موارد مد نظر خود را انتخاب کنید', 'danger');
            return redirect(route('acids.show'));
        }

        foreach ($selectedAcids as $acid) {
            DB::table('acids')->where('id', '=', $acid)->delete();
        }

        //alert message
        flash($request, 'مواد کمک فرآیند با موفقیت حذف شدند', 'danger');

        return redirect(route('acids.show'));
    }
}
