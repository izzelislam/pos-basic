<!DOCTYPE html>
<html>
<head>
	<title>order</title>
</head>
<body>
	<h1>order list</h1>
	<a href="{{ route('order.create') }}">Tumbas</a>
	<table width="100%" border="1">
		<thead>
			<tr>
				<th>Nama Pembeli</th>
				<th>Total</th>
				<th>Tgl</th>
				<th>aksi</th>
			</tr>
		</thead>
		<tbody>
			
				@foreach ($orders as $order)
				<tr>
					<td>{{ $order->customer_name }}</td>
					<td>{{ $order->total }}</td>
					<td>{{ $order->created_at->format('d-m-Y') }}</td>
					<td>
						<a href="{{ route('order.edit',$order->id) }}">edit</a>
						|
						<form action="{{ route('order.destroy',$order->id) }}" method="POST">
							@csrf
							@method('DELETE')
							<button>delete</button>
						</form>
					</td>
				</tr>
				@endforeach
			
		</tbody>
	</table>
</body>
</html>