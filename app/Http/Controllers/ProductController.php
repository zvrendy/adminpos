<?php

namespace App\Http\Controllers;

use File;
use Image;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'products' => Product::paginate(5),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi
        $this->validate($request, [
            'code' => 'required|string|max:10|unique:products',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:100',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'categories' => 'required',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);
        try {
            $filename = "default-150x150.png";
            if ($request->hasFile('photo')) {
                //MAKA KITA SIMPAN SEMENTARA FILE TERSEBUT KEDALAM VARIABLE FILE
                $file = $request->file('photo');
                //KEMUDIAN NAMA FILENYA KITA BUAT CUSTOMER DENGAN PERPADUAN TIME DAN SLUG DARI NAMA PRODUK. ADAPUN EXTENSIONNYA KITA GUNAKAN BAWAAN FILE TERSEBUT
                $filename = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
                //SIMPAN FILENYA KEDALAM FOLDER PUBLIC/PRODUCTS, DAN PARAMETER KEDUA ADALAH NAMA CUSTOM UNTUK FILE TERSEBUT
                $file->storeAs('public/products', $filename);

                // $photo = $this->saveFile($request->name, $request->file('photo'));
                echo $filename;
            }

            Product::create([
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'stock' => $request->stock,
                'price' => $request->price,
                'category_id' => $request->categories['id'],
                'photo' => $filename
            ]);
        } catch (\Exception $e) {
            return back();
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    private function saveFile($name, $photo)
    {
        //set nama file adalah gabungan antara nama produk dan time(). Ekstensi gambar tetap dipertahankan
        $images = Str::slug($name) . time() . '.' . $photo->getClientOriginalExtension();
        //set path untuk menyimpan gambar
        $path = public_path('uploads/product');
        //cek jika uploads/product bukan direktori / folder
        if (!File::isDirectory($path)) {
            //maka folder tersebut dibuat
            File::makeDirectory($path, 0777, true, true);
        }
        //simpan gambar yang diuplaod ke folrder uploads/produk
        Image::make($photo)->save($path . '/' . $images);
        //mengembalikan nama file yang ditampung divariable $images
        return $images;
    }
}
