<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use DataTables;
use DB;
use File;
use PDF;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|string|unique:products',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'photo' => 'image|mimes:jpg,png,jpeg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);
        $products = Product::create($request->except('photo'));
        if ($request->hasFile('photo')) {
            $uploaded_photo = $request->file('photo');
            $extension = $uploaded_photo->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'images';
            $uploaded_photo->move($destinationPath, $filename);
            $products->photo = $filename;
            $products->save();
        }
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Product::findOrfail($id);
        $categories = Category::pluck('name', 'id')->toArray();
        return view('products.edit')->with(compact('products', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|string|unique:products, code' . $id,
            'name' => 'required|string',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'photo' => 'image|mimes:jpg,png,jpeg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);
        $products = Product::find($id);
        $products->update($request->all());
        if ($request->hasFile('photo')) {
            $uploaded_photo = $request->file('photo');
            $extension = $uploaded_photo->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'images';
            $uploaded_photo->move($destinationPath, $filename);

            if ($products->photo) {
                $old_photo = $products->photo;
                $filepath = public_path() . DIRECTORY_SEPARATOR . 'images'
                    . DIRECTORY_SEPARATOR . $products->photo;
                try {
                    File::delete($filepath);                    
                } catch (FileNotFoundException $e) { }
            }
            $products->photo = $filename;
            $products->save();
        }
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Product::find($id);
        if ($products->photo) {
            $old_photo = $products->photo;
            $filepath = public_path() . DIRECTORY_SEPARATOR . 'images'
                . DIRECTORY_SEPARATOR . $products->photo;
            try {
                File::delete($filepath);
            } catch (FileNotFoundException $e) { }
        }
        $products->delete();
        return redirect()->route('products.index');
    }

    public function dataTable()
    {
        $products = Product::with('categories');
        return DataTables::of($products)
            ->addColumn('action', function ($products) {
                return view('products._action', [
                    'products' => $products,
                    'url_edit' => route('products.edit', $products->id),
                    'url_destroy' => route('products.destroy', $products->id)
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function loadCategories(Request $request)
    {
        if ($request->has('q')) {
            $cari = $request->q;
            $data = DB::table('categories')->select('id', 'name')->where('name', 'LIKE', '%' . $cari . '%')->get();
            return response()->json($data);
        }
    }

    public function exportPdf()
    {
        $data = Product::get();
        $pdf = PDF::loadview('pdf.products', compact('data'));
        //$pdf->save(storage_path().'_filename.pdf');
        return $pdf->stream('products.pdf');
    }
}
