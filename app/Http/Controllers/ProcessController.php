<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProcessController extends Controller
{
    public function save(Request $request)
    {
        //rules Validation
        $rules = [
            'name' => 'required',
            'material' => 'required',
            'price' => 'required',
            'salary' => 'required',
        ];

        //Error Messages Validation
        $messages = [
            'name.required' => 'لطفا نام فرآیند را وارد کنید',

            'material.required' => 'لطفا نام ماده خام را را وارد کنید',

            'price.required' => 'لطفا هزینه سربار را وارد کنید',

            'salary.required' => 'لطفا هزینه دستمزد را وارد کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //insert database
        $insertDetails = [
            'name' => $request->get('name'),
            'material' => $request->get('material'),
            'hiddenName' => $request->get('name') . ':' . $request->get('material'),
            'price' => $request->get('price'),
            'salary' => $request->get('salary'),
        ];

        DB::table('processes')->insert($insertDetails);

        //alert message
        flash($request, 'فرآیند با موفقیت اضافه شد', 'success');

        return redirect(route('processes.show'));
    }

    public function update($id, Request $request)
    {
        //rules Validation
        $rules = [
            'name' => ['required'],
            'material' => 'required',
            'price' => 'required',
            'salary' => 'required',
        ];

        //Error Messages Validation
        $messages = [
            'name.required' => 'لطفا نام فرآیند را وارد کنید',

            'material.required' => 'لطفا نام ماده خام را را وارد کنید',

            'price.required' => 'لطفا هزینه سربار را وارد کنید',

            'salary.required' => 'لطفا هزینه دستمزد را وارد کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //update database
        $updateDetails = [
            'name' => $request->get('name'),
            'material' => $request->get('material'),
            'hiddenName' => $request->get('name') . ':' . $request->get('material'),
            'price' => $request->get('price'),
            'salary' => $request->get('salary'),
        ];

        DB::table('processes')
            ->where('id', '=', $id)
            ->update($updateDetails);

        //alert message
        flash($request, 'تغییرات با موفقیت اعمال شد', 'success');

        return redirect(route('processes.show'));
    }

    public function deleteProcess($id, Request $request)
    {
        DB::table('processes')->where('id', '=', $id)->delete();

        //alert message
        flash($request, 'فرآیند با موفقیت حذف شد', 'danger');

        return redirect(route('processes.show'));
    }

    public function deleteAll(Request $request)
    {
        $selectedProcesses = $request->input('processes');

        if ($selectedProcesses == null) {
            flash($request, 'لطفا ابتدا موارد مد نظر خود را انتخاب کنید', 'danger');
            return redirect(route('processes.show'));
        }

        foreach ($selectedProcesses as $process) {
            DB::table('processes')->where('id', '=', $process)->delete();
        }

        //alert message
        flash($request, 'فرآیندها با موفقیت حذف شدند', 'danger');

        return redirect(route('processes.show'));
    }
}
