<!DOCTYPE html>
<html>
<head>
<style>
#data {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#data td, #data th {
  border: 1px solid #ddd;
  text-align: center;
  padding: 3px;
}

#data tr:nth-child(even){background-color: #f2f2f2;}

#data tr:hover {background-color: #ddd;}

#data th {
  padding-top: 12px;
  padding-bottom: 12px;
  background-color: #4c77af;
  color: white;
}
</style>
</head>
<body>
<center>
  <h3>Laporan Data Transaksi @if($from !== null && $to !== null)Dari {{Carbon\Carbon::parse($from)->format('d F Y')}} Sampai {{Carbon\Carbon::parse($to)->format('d F Y')}} @endif</h3>
</center>
<table id="data">
  <tr>
    <th>No</th>
    <th>Date</th>
    <th>Customer Name</th>
    <th>Jumlah Kantong</th>
    <th>Berat Ikan</th>
    <th>Price</th>
    <th>Berat Total</th>
    <th>Total Price</th>
    <th>Bayar</th>
    <th>Driver</th>
  </tr>
  <?php $no = 0 ?>
  @foreach ($data as $item)
  <?php $no++ ?>
  <tr>
    <td>{{$no}}</td>
    <td>{{$item->date->format('d-M-y')}}</td>
    <td>{{$item->customer->name}}</td>
    <td>{{$item->jlh_kantong}}</td>
    <td>{{$item->berat_ikan}} Kg</td>
    <td>@currency($item->harga_ikan)</td>
    <td>{{$item->total_berat}} Kg</td>
    <td>@currency($item->total_harga)</td>
    <td>@currency($item->bayar)</td>
    <td>{{$item->driver->name}}</td>
  </tr>
  @endforeach
</table>
</body>
</html>