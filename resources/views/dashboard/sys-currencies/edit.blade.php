@extends('layouts.app')

@section('content')

    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form role="form" method="POST" action="{{ route('system-currencies-update', $currency->id) }}" >
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Currency</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Currency Information</p>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Currency Name</label>
                                        <input class="form-control" type="text" name="currency_name" value="{{ $currency->currency_name }}">
                                        @error('currency_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Currency Code</label>
                                        <input class="form-control" type="text" name="currency_code" value="{{ $currency->currency_code }}">
                                        @error('currency_code')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price Rate</label>
                                        <input class="form-control" type="text" name="price_rate" value="{{ $currency->price_rate }}">
                                        @error('price_rate')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm ms-auto" style="float:right">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
