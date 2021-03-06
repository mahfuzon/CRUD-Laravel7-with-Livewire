@extends('layouts.template')

@section('title')
    <title>Customer</title>    
@endsection

@section('content')
    @livewire('customer-index')
@endsection

@section('judul')
    Customer
@endsection

@section('script')
    window.addEventListener('closeModalCustomer', event => {
        $('#InsertDataCustomer').modal('hide');
    });

    window.addEventListener('openModalCustomer', event => {
        $('#InsertDataCustomer').modal('show');
    });

    window.addEventListener('openDeleteModalCustomer', event => {
        $('#DeleteDataCustomer').modal('show');
    });

    window.addEventListener('closeDeleteModalCustomer', event => {
        $('#DeleteDataCustomer').modal('hide');
    });    
@endsection
