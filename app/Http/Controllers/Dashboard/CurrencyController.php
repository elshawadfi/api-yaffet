<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{

    public function index()
    {
        $currencies = Currency::all();
        return view('dashboard.currencies.index', compact('currencies'));
    }

    public function add_currency()
    {
        return view('dashboard.currencies.create');
    }

    public function store(StoreCurrencyRequest $request)
    {
        Currency::create([
            'currency_name' => $request->currency_name,
            'currency_code' => $request->currency_code,
            'price_rate'    => $request->price_rate,
        ]);

        return redirect(route('currencies-index'));
    }

    public function edit(int $id)
    {
        $currency = Currency::find($id);

        return view('dashboard.currencies.edit', compact('currency'));
    }

    public function update(StoreCurrencyRequest $request, Currency $currency)
    {
        $currency->update([
            'currency_name' => $request->currency_name,
            'currency_code' => $request->currency_code,
            'price_rate'    => $request->price_rate,
        ]);

        return redirect(route('currencies-index'));
    }


    public function destroy(Currency $currency)
    {
        $currency->delete();

        return redirect(route('currencies-index'));
    }


}
