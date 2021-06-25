<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Morilog\Jalali\CalendarUtils;

class ProductController extends Controller
{
    public function index()
    {
        $products = DB::table('products')->get();
        return view('products/index', compact('products'));
    }


    public function createStepZero(Request $request)
    {
        return view('products/create-step-zero');
    }

    public function postCreateStepZero(Request $request)
    {

        $productName = $request->input('productName');
        $productCode = $request->input('productCode');
        $product = DB::table('products')->where('code', '=', $request->get('productCode'))->get()->first();

        if ($product != null) {
            flash($request, 'کد محصول وارد شده تکراری است', 'danger');
            return redirect(route('products.create.step.zero'));
        }

        if ($productName == null) {
            flash($request, 'لطفا نام محصول خود را وارد کنید', 'danger');
            return redirect(route('products.create.step.zero'));
        }

        if ($productCode == null) {
            flash($request, 'لطفا کد محصول خود را وارد کنید', 'danger');
            return redirect(route('products.create.step.zero'));
        }

        //todo session
        $request->session()->put('productName', $productName);
        $request->session()->put('productCode', $productCode);

        return redirect()->route('products.create.step.one');
    }

    public function createStepOne(Request $request)
    {

        $materials = DB::table('materials')->get();
        return view('products/create-step-one', compact('materials'));
    }

    public function postCreateStepOne(Request $request)
    {
        $selectedMaterials = $request->input('materials');
        $customers = $request->input('customers');

        if ($selectedMaterials == null) {
            //alert message
            flash($request, 'لطفا ماده خام خود را انتخاب کنید', 'danger');
            return redirect(route('products.create.step.one'));
        }

        //todo session
        $request->session()->put('selectedMaterials', $selectedMaterials);
        $request->session()->put('customers', $customers);

        return redirect()->route('products.create.step.two');
    }


    public function createStepTwo(Request $request)
    {
        $selectedMaterials = $request->session()->get('selectedMaterials');
        $processes = DB::table('processes')->get();
        $acids = DB::table('acids')->get();

        return view('products/create-step-two', compact('selectedMaterials', 'processes', 'acids'));
    }

    public function postCreateStepTwo(Request $request)
    {
        $materialProcesses = $request->input('processes');

        if ($materialProcesses == null) {

            flash($request, 'لطفا فرآیند های روی ماده خام را انتخاب کنید', 'danger');
            return redirect(route('products.create.step.two'));
        }

        $acids = $request->input('acids');

        if ($materialProcesses != null) {
            $flag = false;
            foreach ($acids as $acid)
                if ($acid != null) {
                    $flag = true;
                }
            if (!$flag) {
                flash($request, 'لطفا مقادیر مواد کمک فرآیند را انتخاب کنید', 'danger');
                return redirect(route('products.create.step.two'));
            }
        }

        $hiddenAcids = $request->input('hiddenAcids');


        $materialAcidsPair = array();

        $processesPrice = array();
        $processesSalary = array();
        $materialProcessesPricePair = array();
        $materialProcessesSalaryPair = array();

        $acidPrice = array();
        $acidPricePair = array();

        $totalArray = collect();


        $processes = DB::table('processes')->get();
        $acidsDb = DB::table('acids')->get();

        foreach ($processes as $process) {
            $processesPrice[$process->hiddenName] = $process->price;
            $processesSalary[$process->hiddenName] = $process->salary;
        }

        foreach ($acidsDb as $acid) {
            $acidPrice[$acid->name] = $acid->price;
        }

        foreach ($materialProcesses as $process) {
            /*$split = explode(':', $process);
            $splitProcess = $split[0];*/
            $materialProcessesPricePair[$process] = $processesPrice[$process];
            $materialProcessesSalaryPair[$process] = $processesSalary[$process];
        }


        for ($i = 0; $i < sizeof($acids); $i += 1) {
            if ($acids[$i] != null) {
                $split = explode(':', $hiddenAcids[$i]);

                $materialAcidsPair[$hiddenAcids[$i]] = $acids[$i];

                $acidPricePair[$hiddenAcids[$i]] = $acids[$i] * $acidPrice[$split[0]];
            }
        }

        //todo session
        $request->session()->put('materialProcesses', $materialProcesses);
        $request->session()->put('materialProcessesPricePair', $materialProcessesPricePair);
        $request->session()->put('materialProcessesSalaryPair', $materialProcessesSalaryPair);

        $request->session()->put('materialAcidsPair', $materialAcidsPair);
        $request->session()->put('acidPricePair', $acidPricePair);

        return redirect()->route('products.create.step.three');

    }

    public function createStepThree(Request $request)
    {
        $selectedMaterials = $request->session()->get('selectedMaterials');
        return view('products/create-step-three', compact('selectedMaterials'));
    }

    public function postCreateStepThree(Request $request)
    {
        $sum = 0;
        $percents = $request->input('percents');
        $hiddenPercents = $request->input('hiddenPercents');

        $percentPair = array();
        $materialPrice = array();
        $materialPricePair = array();

        $materials = DB::table('materials')->get();
        $customers = $request->session()->get('customers');

        foreach ($materials as $material) {
            $materialPrice[$material->name] = $material->price;
        }

        foreach ($percents as $percent) {
            if ($percent == null) {
                flash($request, 'لطفا درصد تمامی مواد را مشخص کنید', 'danger');
                return redirect(route('products.create.step.three'));
            }
            $sum += $percent;
        }
        if ($sum != 100) {
            flash($request, 'جمع درصد های انتخابی باید برابر 100 باشد', 'danger');
            return redirect(route('products.create.step.three'));
        }

        for ($i = 0; $i < sizeof($percents); $i += 1) {
            if ($percents[$i] != null) {
                $percentPair[$hiddenPercents[$i]] = $percents[$i];

                if ($customers != null) {
                    if (in_array($hiddenPercents[$i], $customers)) {
                        $materialPricePair[$hiddenPercents[$i]] = 0;
                    } else {
                        $materialPricePair[$hiddenPercents[$i]] = $materialPrice[$hiddenPercents[$i]] * ($percents[$i] / 100);
                    }
                } else {
                    $materialPricePair[$hiddenPercents[$i]] = $materialPrice[$hiddenPercents[$i]] * ($percents[$i] / 100);
                }
            }
        }

        //todo session
        $request->session()->put('percentPair', $percentPair);
        $request->session()->put('materialPricePair', $materialPricePair);

        return redirect()->route('products.create.step.four');
    }

    public function createStepFour(Request $request)
    {
        $processes = DB::table('actions')->get();
        $acids = DB::table('acids')->get();

        return view('products/create-step-four', compact('processes', 'acids'));
    }

    public function postCreateStepFour(Request $request)
    {
        // dd($request);
        $productProcesses = $request->input('productProcesses');
        if ($productProcesses == null) {
            flash($request, 'لطفا فرآیند های روی ماده خام را انتخاب کنید', 'danger');
            return redirect(route('products.create.step.four'));
        }

        $productAcids = $request->input('productAcids');
        //dd($productAcids);
        if ($productProcesses != null) {
            $flag = false;
            foreach ($productAcids as $acid)
                if ($acid != null) {
                    $flag = true;
                }
            if (!$flag) {
                flash($request, 'لطفا مقادیر مواد کمک فرآیند را انتخاب کنید', 'danger');
                return redirect(route('products.create.step.four'));
            }
        }

        $hiddenProductAcids = $request->input('hiddenProductAcids');
        //dd($hiddenProductAcids);

        $productAcidsPair = array();

        $processesPrice = array();
        $processesSalary = array();
        $productProcessesPricePair = array();
        $productProcessesSalaryPair = array();

        $acidPrice = array();
        $productAcidPricePair = array();

        $processes = DB::table('actions')->get();
        $acidsDb = DB::table('acids')->get();

        foreach ($processes as $process) {
            $processesPrice[$process->name] = $process->price;
            $processesSalary[$process->name] = $process->salary;
        }

        foreach ($acidsDb as $acid) {
            $acidPrice[$acid->name] = $acid->price;
        }


        foreach ($productProcesses as $process) {
            $productProcessesPricePair[$process] = $processesPrice[$process];
            $productProcessesSalaryPair[$process] = $processesSalary[$process];
        }

        for ($i = 0; $i < sizeof($productAcids); $i += 1) {
            if ($productAcids[$i] != null) {

                $split = explode(':', $hiddenProductAcids[$i]);

                $productAcidsPair[$hiddenProductAcids[$i]] = $productAcids[$i];

                $productAcidPricePair[$hiddenProductAcids[$i]] = $productAcids[$i] * $acidPrice[$split[0]];
            }
        }

        //todo session
        $request->session()->put('productProcesses', $productProcesses);
        $request->session()->put('productProcessesPricePair', $productProcessesPricePair);
        $request->session()->put('productProcessesSalaryPair', $productProcessesSalaryPair);
        $request->session()->put('productAcidsPair', $productAcidsPair);
        $request->session()->put('productAcidPricePair', $productAcidPricePair);


        return redirect()->route('products.create.step.five');

    }

    public function createStepFive(Request $request)
    {
        $packs = DB::table('packs')->get();
        return view('products/create-step-five', compact('packs'));
    }

    public function postCreateStepFive(Request $request)
    {
        // dd($request);
        $selectedPacks = $request->input('packs');
        $units = $request->input('units');
        $hiddenUnits = $request->input('hiddenUnits');

        $packsPair = array();

        $packPrice = array();
        $packPricePair = array();
        $packUnitPair = array();

        $packs = DB::table('packs')->get();

        foreach ($packs as $pack) {
            $packPrice[$pack->name] = $pack->price;
            $packUnitPair[$pack->name] = $pack->unit;
        }

        if ($selectedPacks == null) {
            //alert message
            flash($request, 'لطفا بسته بندی خود را انتخاب کنید', 'danger');
            return redirect(route('products.create.step.five'));
        }

        /*if (($units != null) and ($hiddenUnits != null)) {*/

            for ($i = 0; $i < sizeof($units); $i += 1) {
                if ($units[$i] != null) {
                    $packsPair[$hiddenUnits[$i]] = $units[$i];
                    $packPricePair[$hiddenUnits[$i]] = $packPrice[$hiddenUnits[$i]] * $units[$i];
                }
            }



        //todo session
        $request->session()->put('packsPair', $packsPair);
        $request->session()->put('packPricePair', $packPricePair);
        $request->session()->put('packUnitPair', $packUnitPair);

        return redirect()->route('products.create.step.six');

    }

    public function createStepSix(Request $request)
    {
        $totalPrice = 0;

        //todo step 0
        $productName = $request->session()->get('productName');
        $productCode = $request->session()->get('productCode');

        //todo step 1
        $selectedMaterials = $request->session()->get('selectedMaterials');

        //todo step 2
        $materialProcesses = $request->session()->get('materialProcesses');
        $materialProcessesPricePair = $request->session()->get('materialProcessesPricePair');
        $materialProcessesSalaryPair = $request->session()->get('materialProcessesSalaryPair');

        foreach ($materialProcessesPricePair as $price) {
            $totalPrice += $price;
        }
        foreach ($materialProcessesSalaryPair as $price) {
            $totalPrice += $price;
        }


        $materialAcidsPair = $request->session()->get('materialAcidsPair');
        $materialAcidsPairKey = array_keys($materialAcidsPair);
        $acidPricePair = $request->session()->get('acidPricePair');

        foreach ($acidPricePair as $price) {
            $totalPrice += $price;
        }


        //todo step 3
        $percentPair = $request->session()->get('percentPair');
        $materialPricePair = $request->session()->get('materialPricePair');

        foreach ($materialPricePair as $price) {
            $totalPrice += $price;
        }

        //todo step 4
        $productProcesses = $request->session()->get('productProcesses');

        $productProcessesPricePair = $request->session()->get('productProcessesPricePair');
        $productProcessesSalaryPair = $request->session()->get('productProcessesSalaryPair');

        foreach ($productProcessesPricePair as $price) {
            $totalPrice += $price;
        }
        foreach ($productProcessesSalaryPair as $price) {
            $totalPrice += $price;
        }


        $productAcidsPair = $request->session()->get('productAcidsPair');

        $productAcidsPairKey = array_keys($productAcidsPair);
        $productAcidPricePair = $request->session()->get('productAcidPricePair');

        foreach ($productAcidPricePair as $price) {
            $totalPrice += $price;
        }


        //todo step 5
        $packsPair = $request->session()->get('packsPair');
        $packsPairKey = array_keys($packsPair);
        $packUnitPair = $request->session()->get('packUnitPair');
        $packPricePair = $request->session()->get('packPricePair');

        foreach ($packPricePair as $price) {
            $totalPrice += $price;
        }

        $request->session()->put('totalPrice', $totalPrice);

        $createDate = CalendarUtils::strftime('d-m-Y', strtotime(now()));

        $product_id = 0;
        //todo management report
        $view_content = View::make('products/document', compact('selectedMaterials', 'percentPair'
            , 'materialPricePair', 'materialAcidsPair', 'acidPricePair', 'materialAcidsPairKey'
            , 'materialProcesses', 'materialProcessesPricePair', 'materialProcessesSalaryPair'
            , 'productProcesses', 'productAcidsPair', 'productAcidsPairKey'
            , 'productProcessesPricePair', 'productProcessesSalaryPair', 'productAcidPricePair'
            , 'packsPair', 'packPricePair', 'packsPairKey', 'packUnitPair', 'totalPrice', 'productName', 'productCode', 'createDate'))->render();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addText($view_content);

        $lastProduct = DB::table('products')->get()->last();
        if ($lastProduct == null) {
            $product_id = 1;
        } else {
            $product_id = $lastProduct->id + 1;
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');

        $name = $productName;
        $code = $productCode;
        $date = CalendarUtils::strftime('Y-m-d', strtotime(now()));
        $fileName = $productName . $product_id . '_' . $date . '.html';

        //todo BOM report
        $bom_content = View::make('products/bom', compact('selectedMaterials', 'percentPair'
            , 'materialAcidsPair', 'materialAcidsPairKey'
            , 'materialProcesses', 'productProcesses', 'productAcidsPair'
            , 'productAcidsPairKey'))->render();

        $phpWordBOM = new \PhpOffice\PhpWord\PhpWord();
        $sectionBOM = $phpWordBOM->addSection();
        $sectionBOM->addText($bom_content);

        $objWriterBOM = \PhpOffice\PhpWord\IOFactory::createWriter($phpWordBOM, 'HTML');

        $nameBOM = $productName . $product_id . '_' . 'BOM';
        $bom = $nameBOM . '_' . $date . '.html';

        //insert database
        $insertDetails = [
            'id' => $product_id,
            'name' => $name,
            'code' => $code,
            'price' => $totalPrice,
            'fileName' => $fileName,
            'bom' => $bom,
            'date' => $date,
            'user_id' => auth()->user()->id,
            'creator' => auth()->user()->username,
            'state' => "nonConfirmed",
        ];

        DB::table('products')->insert($insertDetails);

        $objWriter->save(storage_path($fileName));
        $objWriterBOM->save(storage_path($bom));

        $request->session()->put('fileName', $fileName);
        $request->session()->put('bom', $bom);
        $request->session()->put('product_id', $product_id);

        return view('products/create-step-six', compact('selectedMaterials', 'percentPair'
            , 'materialPricePair', 'materialAcidsPair', 'acidPricePair', 'materialAcidsPairKey'
            , 'materialProcesses', 'materialProcessesPricePair', 'materialProcessesSalaryPair'
            , 'productProcesses', 'productAcidsPair', 'productAcidsPairKey'
            , 'productProcessesPricePair', 'productProcessesSalaryPair', 'productAcidPricePair'
            , 'packsPair', 'packPricePair', 'packsPairKey', 'packUnitPair', 'totalPrice', 'productName', 'productCode', 'createDate'));
    }

    public function postCreateStepSix(Request $request)
    {
        $product_id = $request->session()->get('product_id');

        //update database
        $updateDetails = [
            'state' => "confirmed"
        ];

        DB::table('products')
            ->where('id', '=', $product_id)
            ->update($updateDetails);

        return redirect()->route('products.create.step.seven');
    }

    public function createStepSeven(Request $request)
    {
        $totalPrice = $request->session()->get('totalPrice');
        return view('products/create-step-seven', compact('totalPrice'));
    }

    public function confirmProduct($id, Request $request)
    {
        //update database
        $updateDetails = [
            'state' => "confirmed"
        ];

        DB::table('products')
            ->where('id', '=', $id)
            ->update($updateDetails);

        //alert message

        flash($request, 'محصول با موفقیت تایید شد', 'success');

        $products = DB::table('products')->where('state', '=', 'confirmed')->paginate(10);
        return view('products/confirmed_products', compact('products'));
    }

    public function generateDocx(Request $request)
    {
        $fileName = $request->session()->get('fileName');
        return response()->download(storage_path($fileName));
    }

    public function generateBom(Request $request)
    {
        $bom = $request->session()->get('bom');
        return response()->download(storage_path($bom));
    }

    public function downloadReport($fileName)
    {
        return response()->download(storage_path($fileName));
    }

    public function downloadBom($bom)
    {
        return response()->download(storage_path($bom));
    }

    public function deleteProduct($id, Request $request)
    {
        DB::table('products')->where('id', '=', $id)->delete();

        //alert message
        flash($request, 'محصول با موفقیت حذف شد', 'danger');

        return redirect(route('products.show'));
    }

    public function deleteConfirmedProduct($id, Request $request)
    {

        DB::table('products')->where('id', '=', $id)->delete();

        //alert message
        flash($request, 'محصول با موفقیت حذف شد', 'danger');

        return redirect(route('products.confirmed.show'));
    }

    public function deleteAll(Request $request)
    {
        $selectedProducts = $request->input('products');

        if ($selectedProducts == null) {
            flash($request, 'لطفا ابتدا موارد مد نظر خود را انتخاب کنید', 'danger');
            return redirect(route('products.show'));
        }

        foreach ($selectedProducts as $product) {
            DB::table('products')->where('id', '=', $product)->delete();
        }
        //alert message
        flash($request, 'محصولات با موفقیت حذف شدند', 'danger');
        return redirect(route('products.show'));
    }

    public function deleteAllConfirmed(Request $request)
    {
        $selectedProducts = $request->input('products');

        if ($selectedProducts == null) {
            flash($request, 'لطفا ابتدا موارد مد نظر خود را انتخاب کنید', 'danger');
            return redirect(route('products.show'));
        }

        foreach ($selectedProducts as $product) {
            DB::table('products')->where('id', '=', $product)->delete();
        }
        //alert message
        flash($request, 'محصولات با موفقیت حذف شدند', 'danger');
        return redirect(route('products.confirmed.show'));
    }

}
