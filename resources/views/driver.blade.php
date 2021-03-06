@extends('layouts.template')

@section('content')
    @livewire('driver-index')
@endsection

@section('title')
    <title>Driver</title>
@endsection

@section('judul')
    Driver
@endsection

@section('script')
    window.addEventListener('closeModalDriver', event => {
        $('#InsertDataDriver').modal('hide');
    });

    window.addEventListener('openModalDriver', event => {
        $('#InsertDataDriver').modal('show');
    });

    window.addEventListener('openDeleteModalDriver', event => {
        $('#DeleteDataDriver').modal('show');
    });

    window.addEventListener('closeDeleteModalDriver', event => {
        $('#DeleteDataDriver').modal('hide');
    });
@endsection