@extends('layouts.app')

@section('content')

    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-2">
        <div class="row min-height-500">
            <div class="col-md-12">
                <div class="card">
                    <form role="form" method="POST" action="{{ route('system-currencies-store') }}" >
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Add Currency</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Currency Information</p>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Currency Name</label>
                                        <input class="form-control" type="text" name="currency_name" value="{{ old('currency_name')}}">
                                        @error('currency_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Currency Code</label>
                                        <input class="form-control" type="text" name="currency_code" value="{{ old('currency_code') }}">
                                        @error('currency_code')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price Rate</label>
                                        <input class="form-control" type="text" name="price_rate" value="{{ old('price_rate') }}">
                                        @error('price_rate')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm ms-auto" style="float:right">Save</button>
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
