<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    function getProducts()
    {
        return  Product::select('fld_pid', 'fld_p_id', 'fld_name', 'fld_type', 'fld_status', 'fld_sku', 'fld_display_order', 'fld_mrp', 'fld_cost_price', 'fld_selling_price')
            ->selectRaw(
                'CASE
            WHEN fld_type = 1 THEN "Retail"
            WHEN fld_type = 2 THEN "Order Booking"
            ELSE "Unknown"
         END AS fld_type,
        CASE
         WHEN fld_display_order = 0 THEN "No"
         WHEN fld_display_order = 1 THEN "Yes"
         ELSE "Unknown"
      END AS display_order'
            )->orderBy('products.fld_pid', 'desc')->paginate(15);
    }

    public function index(): View
    {
        $projects = DB::table('projects')->where('fld_status', 1)->get();
        $records = $this->getProducts();
        return view('product.index', compact('records', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fld_p_id' => 'required',
            'fld_name' => 'required|unique:products',
            'fld_type' => 'required',
            'fld_sku' => 'required|unique:products',
            'fld_mrp' => 'required',
            'fld_cost_price' => 'required',
            'fld_selling_price' => 'required'
        ]);
        $data = $request->all();
        $data['fld_status'] = (isset($data['status'])) ? 1 : 0;
        $data['fld_display_order'] = (isset($data['fld_display_order'])) ? 1 : 0;
        Product::create($data);
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $projects = DB::table('projects')->where('fld_status', 1)->get();
        $records = $this->getProducts();
        return view('product.index', compact('product', 'records', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function updateStatus(Request $request)
    {
        $product_id = $request->product_id;
        $status = $request->status;
        $product = Product::find($product_id);
        $product->fld_status = $status;
        $product->save();
        return 1;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'fld_name' => 'required|unique:products,fld_name,' . $product->fld_pid . ',fld_pid',
            'fld_p_id' => 'required',
            'fld_type' => 'required',
            'status' => 'required',
            'fld_sku' => 'required|unique:products,fld_sku,' . $product->fld_pid . ',fld_pid',
            'fld_mrp' => 'required',
            'fld_cost_price' => 'required',
            'fld_selling_price' => 'required'
        ]);

        $data = $request->all();
        $data['fld_status'] = (isset($data['status'])) ? 1 : 0;
        $data['fld_display_order'] = (isset($data['fld_display_order'])) ? 1 : 0;
        $product->update($data);
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
