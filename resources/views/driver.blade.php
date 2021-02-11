@extends('layouts.template')

@section('content')
    @livewire('driver-index')
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