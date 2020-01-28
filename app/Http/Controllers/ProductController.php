<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Redirect, Response;
use Yajra\DataTables\Contracts\DataTable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $products = Product::all();

            return datatables()->of($products)
                ->addColumn('action', function ($products) {
                    return
                        '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $products->id . '" data-original-title="Edit" class="edit btn btn-success edit-product">
                        Edit
                    </a>
                    <a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Delete" data-id="' . $products->id . '" class="delete btn btn-danger delete-product">
                        Delete
                    </a>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('list');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productId = $request->product_id;
        $product   =   Product::updateOrCreate(
            ['id' => $productId],
            ['title' => $request->title, 'product_code' => $request->product_code, 'description' => $request->description]
        );
        return Response::json($product);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $product  = Product::where($where)->first();

        return Response::json($product);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)->delete();

        return Response::json($product);
    }
}
