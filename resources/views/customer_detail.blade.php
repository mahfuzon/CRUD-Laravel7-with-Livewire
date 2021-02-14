@extends('layouts.template')

@section('content')
    @livewire('show-customer', ['customer_id' => $id])
@endsection

@section('title')
    <title>Detail Transaksi</title>
@endsection