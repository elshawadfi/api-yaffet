<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHighestPriceRequest;
use App\Models\HighestPrice;
use Illuminate\Http\Request;

class HighestPriceController extends Controller
{
    public function index()
    {
        $data = HighestPrice::all();
        
        return view('dashboard.highest-price.index', compact('data'));
    }




    public function edit(int $id)
    {
        $data = HighestPrice::find($id);

        return view('dashboard.highest-price.edit', compact('data'));
    }

    public function update(StoreHighestPriceRequest $request, HighestPrice $metal_price)
    {
        $metal_price->update([
            'metal_code'  => $request->metal_code,
            'price'       => $request->price,
            'currency'    => $request->currency,
            'price_date'  => $request->price_date,
            'unit'        => $request->unit,

        ]);

        return redirect()->route('highest-index')->with('success', 'Updated Successfully');
    }


    // public function destroy(Currency $currency)
    // {
    //     $currency->delete();

    //     return redirect(route('currencies-index'));
    // }

}
