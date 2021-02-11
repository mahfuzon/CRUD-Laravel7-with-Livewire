@extends('layouts.template')

@section('content')
    @livewire('transaction-index')
@endsection

@section('judul')
    Transaction
@endsection

@section('title')
    <title>Transaction</title>
@endsection

@section('script')
window.addEventListener('closeModalTransaction', event => {
    $('#InsertDataTransaction').modal('hide');
});

window.addEventListener('openModalTransaction', event => {
    $('#InsertDataTransaction').modal('show');
});

window.addEventListener('openDeleteModalTransaction', event => {
    $('#DeleteDataTransaction').modal('show');
});

window.addEventListener('closeDeleteModalTransaction', event => {
    $('#DeleteDataTransaction').modal('hide');
});
@endsection