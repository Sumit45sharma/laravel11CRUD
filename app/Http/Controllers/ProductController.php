<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();

        // Retrieve the last added product ID from the cookie
        $lastAddedProduct = Cookie::get('last_added_product');

        return view('products.list', [
            'products' => $products,
            'lastAddedProduct' => $lastAddedProduct
        ]);
    }
    public function create()
    {
        return view('products.create');


    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:5',
            'password' => 'required|min:5',
            'price' => 'required|numeric',
        ];
        if ($request->image != "") {
            $rules['image'] = 'image';
        }


        $validator = validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->password = bcrypt($request->password);
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->image != "") {
            // here we will store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext; //unique image name
            $image->move(public_path('uploads/products'), $imageName);

            // save image name in database
            $product->image = $imageName;
            $product->save();
        }


        // Store a flash message in session
        session()->flash('success', 'Product added successfully.');

        // Set a cookie to remember the last added product
        Cookie::queue('last_added_product', $product->id, 60); // 60 minutes

        return redirect()->route('products.index')->with('success', 'Product added successfully. ');

    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', [
            'product' => $product
        ]);
    }
    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $rules = [
            'name' => 'required|min:5',
            'password' => 'required|min:3',
            'price' => 'required|numeric'
        ];

        if ($request->image != "") {
            $rules['image'] = 'image';

        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.edit', $product->id)->withInput()->withErrors($validator);
        }

        //here udate product
        $product->name = $request->name;
        $product->password = $request->password;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->image != "") {
            //here we will delete image
            File::delete(public_path('uploads/products/' . $product->image));

            // here we will store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext; //unique image name
            $image->move(public_path('uploads/products'),$imageName);

            // save image name in database
            $product->image = $imageName;
            $product->save();
        }
        return redirect()->route('products.index')->with('success', 'Product updated successfully. ');


    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        //delete image
        File::delete(public_path('uploads/products/' . $product->image));

        //delete product from database
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully. ');


    }
}
