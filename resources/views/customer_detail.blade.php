@extends('layouts.template')

@section('content')
    @livewire('show-customer', ['customer_id' => $id])
@endsection

@section('title')
    <title>Detail Transaksi</title>
@endsection

@section('judul')
<a href="/home"><i class="fas fa-arrow-circle-left" style="color: darkgray"></i></a> Transaction {{$customer_name}}
@endsection

@section('script')
window.addEventListener('openDetailModalShow', event => {
    $('#detailModalShow').modal('show');
});

window.addEventListener('openEditModalTransactionCustomer', event => {
    $('#EditDataTransactionCustomer').modal('show');
});

window.addEventListener('closeModalTransactionCustomer', event => {
    $('#EditDataTransactionCustomer').modal('hide');
});

window.addEventListener('openDeleteModalTransactionCustomer', event => {
    $('#DeleteDataTransactionCustomer').modal('show');
});

window.addEventListener('closeDeleteModalTransactionCustomer', event => {
    $('#DeleteDataTransactionCustomer').modal('hide');
});
@endsection
