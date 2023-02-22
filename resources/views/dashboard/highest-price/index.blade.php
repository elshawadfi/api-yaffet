@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Tables'])
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="row">
                        <div class="col-10">
                            <div class="card-header pb-2">
                                <h6>Highest Prices</h6>
                            </div>
                        </div>    
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 min-height-300">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Metal Code</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Price</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Currency</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Unit</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $item->metal_code }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->price }}</p>
                                            <p class="text-xs text-secondary mb-0"></p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success">{{ $item->currency }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $item->unit }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('highest-edit', $item->id) }}" class="m-2"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('highest-destroy', $item->id) }}" class="m-2"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                       

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @include('layouts.footers.auth.footer')
            </div>
        </div>
    </div>
@endsection
