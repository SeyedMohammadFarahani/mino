<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    public function save(Request $request)
    {
        //rules Validation
        $rules = [
            'name' => ['required', 'unique:materials'],
            'price' => 'required',
        ];

        //Error Messages Validation
        $messages = [
            'name.required' => 'لطفا نام ماده خام را وارد کنید',
            'name.unique' => 'این ماده قبلا وارد شده است',
            'price.required' => 'لطفا قیمت ماده خام را وارد کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //insert database
        $insertDetails = [
            'name' => $request->get('name'),
            'price' => $request->get('price'),
        ];

        DB::table('materials')->insert($insertDetails);

        //alert message
        flash($request, 'ماده خام با موفقیت اضافه شد', 'success');

        return redirect(route('materials.show'));
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
            'name.required' => 'لطفا نام ماده خام را وارد کنید',
            'price.required' => 'لطفا قیمت ماده خام را وارد کنید',
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
        DB::table('materials')
            ->where('id', '=', $id)
            ->update($updateDetails);

        //alert message
        flash($request, 'تغییرات با موفقیت اعمال شد', 'success');

        return redirect(route('materials.show'));
    }

    public function deleteMaterial($id, Request $request)
    {
        DB::table('materials')->where('id', '=', $id)->delete();

        //alert message
        flash($request, 'ماده خام با موفقیت حذف شد', 'danger');

        return redirect(route('materials.show'));
    }

    public function deleteAll(Request $request)
    {
        $selectedMaterials = $request->input('materials');

        if ($selectedMaterials == null) {
            flash($request, 'لطفا ابتدا موارد مد نظر خود را انتخاب کنید', 'danger');
            return redirect(route('materials.show'));
        }

        foreach ($selectedMaterials as $material) {
            DB::table('materials')->where('id', '=', $material)->delete();
        }

        //alert message
        flash($request, 'مواد خام با موفقیت حذف شدند', 'danger');

        return redirect(route('materials.show'));
    }
}
