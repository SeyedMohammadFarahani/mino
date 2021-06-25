<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function showUsers()
    {
        $users = DB::table('users')->paginate(10);
        return view('user/users', compact('users'));
    }

    public function showEditUser($id)
    {
        $user = DB::table('users')->get()->where('id', '=', $id)->first();
        return view('user/edit_user', compact('user'));
    }

    public function showTransactions()
    {
        $transactions = DB::table('transactions')->paginate(10);
        return view('transaction/transactions', compact('transactions'));
    }

    public function showEditTransaction($id)
    {
        $transaction = DB::table('transactions')->get()->where('id', '=', $id)->first();
        return view('transaction/edit_transaction', compact('transaction'));
    }


    public function showMaterials()
    {
        $materials = DB::table('materials')->paginate(10);
        return view('material/materials', compact('materials'));
    }

    public function showEditMaterial($id)
    {
        $material = DB::table('materials')->get()->where('id', '=', $id)->first();
        return view('material/edit_material', compact('material'));
    }

    public function showPacks()
    {
        $packs = DB::table('packs')->paginate(10);
        return view('pack/packs', compact('packs'));
    }

    public function showEditPack($id)
    {
        $pack = DB::table('packs')->get()->where('id', '=', $id)->first();
        return view('pack/edit_pack', compact('pack'));
    }

    public function showProcesses()
    {
        $processes = DB::table('processes')->paginate(10);
        return view('process/processes', compact('processes'));
    }

    public function showEditProcess($id)
    {
        $materials = \App\Material::all();
        $process = DB::table('processes')->get()->where('id', '=', $id)->first();
        return view('process/edit_process', compact('process', 'materials'));
    }

    public function showActions()
    {
        $actions = DB::table('actions')->paginate(10);
        return view('action/actions', compact('actions'));
    }

    public function showEditAction($id)
    {
        $action = DB::table('actions')->get()->where('id', '=', $id)->first();
        return view('action/edit_action', compact('action'));
    }

    public function showAcids()
    {
        $acids = DB::table('acids')->paginate(10);
        return view('acid/acids', compact('acids'));
    }

    public function showEditAcid($id)
    {
        $acid = DB::table('acids')->get()->where('id', '=', $id)->first();
        return view('acid/edit_acid', compact('acid'));
    }

    public function showProducts()
    {
        $products = DB::table('products')->where('state', '=', 'nonConfirmed')->paginate(10);
        return view('products/products', compact('products'));
    }

    public function showConfirmedProducts()
    {
        $products = DB::table('products')->where('state', '=', 'confirmed')->paginate(10);
        return view('products/confirmed_products', compact('products'));
    }
}
