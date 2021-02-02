@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Transaction') }}</div>
                <div class="card-body">
                    @livewire('transaction-index')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection