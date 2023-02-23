@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Currencies'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="row">
                        <div class="col-10">
                            <div class="card-header pb-2">
                                <h6>System Currencies</h6>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card-header pb-2">
                                <a href="{{ route('system-currencies-create') }}" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
    
                        <div id="alert">
                            @include('components.alert')
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Currency Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Currency Rate</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Currency Code</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Last Update</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($currencies as $currency)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $currency->currency_name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $currency->price_rate }}</p>
                                            <p class="text-xs text-secondary mb-0"></p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success">{{ $currency->currency_code }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ date_format($currency->updated_at, 'd-m-Y') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('system-currencies-edit', $currency->id) }}" class="m-2"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('system-currencies-destroy', $currency->id) }}" class="m-2"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                       

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
