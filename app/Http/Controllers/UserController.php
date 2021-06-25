<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function save(Request $request)
    {
        //rules Validation
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'lastName' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string'],
        ];

        //Error Messages Validation
        $messages = [
            'name.required' => 'لطفا نام کاربر را وارد کنید',
            'name.max' => 'طول نام کاربر بیش از حد مجاز است',
            'lastName.required' => 'لطفا نام خانوادگی کاربر را وارد کنید',
            'lastName.max' => 'طول نام خانوادگی کاربر بیش از حد مجاز است',
            'username.required' => 'لطفا نام کاربری را وارد کنید',
            'username.max' => 'طول نام کاربری بیش از حد مجاز است',
            'username.unique' => 'این نام کاربری قبلا انتخاب شده است',
            'password.required' => 'لطفا رمز عبور را وارد کنید',
            'password.min' => 'رمز عبور باید حداقل 8 رقم باشد',
            'role.required' => 'لطفا نقش کاربر را مضخص کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //insert database
        $insertDetails = [
            'name' => $request->get('name'),
            'lastName' => $request->get('lastName'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'role' => $request->get('role'),
        ];

        DB::table('users')->insert($insertDetails);

        //alert message
        flash($request, 'کاربر با موفقیت اضافه شد', 'success');

        return redirect(route('users.show'));
    }

    public function update($id, Request $request)
    {
        //rules Validation
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'lastName' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50'],
            'role' => ['required', 'string'],
        ];

        //Error Messages Validation
        $messages = [
            'name.required' => 'لطفا نام کاربر را وارد کنید',
            'name.max' => 'طول نام کاربر بیش از حد مجاز است',
            'lastName.required' => 'لطفا نام خانوادگی کاربر را وارد کنید',
            'lastName.max' => 'طول نام خانوادگی کاربر بیش از حد مجاز است',
            'username.required' => 'لطفا نام کاربری را وارد کنید',
            'username.max' => 'طول نام کاربری بیش از حد مجاز است',
            'role.required' => 'لطفا نقش کاربر را مضخص کنید',
        ];

        //Call Validation
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();

        //update database
        $updateDetails = [
            'name' => $request->get('name'),
            'lastName' => $request->get('lastName'),
            'username' => $request->get('username'),
            'role' => $request->get('role'),
        ];

        DB::table('users')
            ->where('id', '=', $id)
            ->update($updateDetails);

        //alert message
        flash($request, 'تغییرات با موفقیت اعمال شد', 'success');

        return redirect(route('users.show'));
    }

    public function deleteUser($id, Request $request)
    {
        DB::table('users')->where('id', '=', $id)->delete();

        //alert message
        flash($request, 'فرآیند با موفقیت حذف شد', 'danger');

        return redirect(route('users.show'));
    }

    public function deleteAll(Request $request)
    {
        $selectedUsers = $request->input('users');

        if ($selectedUsers == null) {
            flash($request, 'لطفا ابتدا موارد مد نظر خود را انتخاب کنید', 'danger');
            return redirect(route('users.show'));
        }

        foreach ($selectedUsers as $user) {
            DB::table('users')->where('id', '=', $user)->delete();
        }

        //alert message
        flash($request, 'کاربرها با موفقیت حذف شدند', 'danger');

        return redirect(route('users.show'));
    }
}
