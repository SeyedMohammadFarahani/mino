<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActionController extends Controller
{
    public function save(Request $request)
    {
        //rules Validation
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'salary' => 'required',
        ];

        //Error Messages Validation
        $messages = [
            'name.required' => 'لطفا نام فرآیند را وارد کنید',

            'price.required' => 'لطفا هزینه سربار را وارد کنید',

            'salary.required' => 'لطفا هزینه دستمزد را وارد کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //insert database
        $insertDetails = [
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'salary' => $request->get('salary'),
        ];

        DB::table('actions')->insert($insertDetails);

        //alert message
        flash($request, 'فرآیند با موفقیت اضافه شد', 'success');

        return redirect(route('actions.show'));
    }

    public function update($id, Request $request)
    {
        //rules Validation
        $rules = [
            'name' => ['required'],
            'price' => 'required',
            'salary' => 'required',
        ];

        //Error Messages Validation
        $messages = [
            'name.required' => 'لطفا نام فرآیند را وارد کنید',
            'price.required' => 'لطفا هزینه سربار را وارد کنید',
            'salary.required' => 'لطفا هزینه دستمزد را وارد کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //update database
        $updateDetails = [
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'salary' => $request->get('salary'),
        ];

        DB::table('actions')
            ->where('id', '=', $id)
            ->update($updateDetails);

        //alert message
        flash($request, 'تغییرات با موفقیت اعمال شد', 'success');

        return redirect(route('actions.show'));
    }

    public function deleteAction($id, Request $request)
    {
        DB::table('actions')->where('id', '=', $id)->delete();

        //alert message
        flash($request, 'فرآیند با موفقیت حذف شد', 'danger');

        return redirect(route('actions.show'));
    }

    public function deleteAll(Request $request)
    {
        $selectedProcesses = $request->input('actions');

        if ($selectedProcesses == null) {
            flash($request, 'لطفا ابتدا موارد مد نظر خود را انتخاب کنید', 'danger');
            return redirect(route('actions.show'));
        }

        foreach ($selectedProcesses as $process) {
            DB::table('actions')->where('id', '=', $process)->delete();
        }

        //alert message
        flash($request, 'فرآیندها با موفقیت حذف شدند', 'danger');

        return redirect(route('actions.show'));
    }
}
