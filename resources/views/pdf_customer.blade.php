<!DOCTYPE html>
<html>

<head>
  <style>
    #data {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #data td,
    #data th {
      border: 1px solid #ddd;
      text-align: center;
      padding: 3px;
    }

    #data tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #data tr:hover {
      background-color: #ddd;
    }

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
    <h3>Laporan Data Transaksi @if($from !== null && $to !== null)Dari {{Carbon\Carbon::parse($from)->format('d F Y')}}
      Sampai {{Carbon\Carbon::parse($to)->format('d F Y')}} @endif</h3>
  </center>
  <table id="data">
    <tr>
      <th>No</th>
      <th>Date</th>
      <th>Berat Total</th>
      <th>Total Price</th>
      <th>Bayar</th>
      <th>Hutang</th>
    </tr>
    <?php $no = 0 ?>
    @foreach ($data as $item)
    <?php $no++ ?>
    <tr>
      <td>{{$no}}</td>
      <td>{{$item->date->format('d-M-y')}}</td>
      <td>{{$item->total_berat}} Kg</td>
      <td>@currency($item->total_harga)</td>
      <td>@currency($item->bayar)</td>
      <td @if ($item->hutang < 0) style="color:green"@else style="color: red"  @endif>@currency(abs($item->hutang))</td>
    </tr>
    @endforeach
  </table>
</body>

</html>