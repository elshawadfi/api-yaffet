<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurrencyRequest;
use App\Models\SystemCurrencies;
use Illuminate\Http\Request;

class SystemCurrenciesController extends Controller
{
    public function index()
    {
        $currencies = SystemCurrencies::all();
        return view('dashboard.sys-currencies.index', compact('currencies'));
    }

    public function add_currency()
    {
        return view('dashboard.sys-currencies.create');
    }

    public function store(StoreCurrencyRequest $request)
    {
        SystemCurrencies::create([
            'currency_name' => $request->currency_name,
            'currency_code' => $request->currency_code,
            'price_rate'    => $request->price_rate,
        ]);

        return redirect()->route('system-currencies-index')->with('success', 'Currency Saved Successfully.');
    }

    public function edit(int $id)
    {
        $currency = SystemCurrencies::find($id);

        return view('dashboard.sys-currencies.edit', compact('currency'));
    }

    public function update(StoreCurrencyRequest $request, SystemCurrencies $currency)
    {
        $currency->update([
            'currency_name' => $request->currency_name,
            'currency_code' => $request->currency_code,
            'price_rate'    => $request->price_rate,
        ]);

        return redirect()->route('system-currencies-index')->with('success', 'Currency Updated Successfully.');
    }


    public function destroy(SystemCurrencies $currency)
    {
        $currency->delete();

        return redirect()->route('system-currencies-index');
    }

}
