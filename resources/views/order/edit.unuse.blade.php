<!DOCTYPE html>
<html>
<head>
	<title>create</title>
</head>
<body>
	<h1>create</h1>

	<form action="{{ route('order.store') }}" method="post">
		@csrf
		<div x-data="instance()">
			<label>
				Nama Pembeli
				<input type="text" name="customer_name" value="{{ $order->customer_name }}">
			</label>
			<br><br>
			<template x-for="(row ,index) in rows" :key="row">
				<div >
					<label>
						item
						<select name="item_id[]" x-model=row.item_id x-on:change="setPrice(row.item_id,index)">
							<option value="">-- pilih item --</option>
							@foreach ($items as $item)
								<option value="{{ $item->id }}">{{ $item->name }}</option>
							@endforeach
						</select>
					</label>

					&nbsp;&nbsp;&nbsp;
					<label>
						qty
						<input type="number" name="qty[]" x-model="row.qty" x-on:change="setSub(index)">
					</label>


					&nbsp;&nbsp;&nbsp;
					<label>
						Harga Satuan
						<input type="number" name="price[]" x-model="row.price" readonly>
					</label>

					&nbsp;&nbsp;&nbsp;
					<label>
						subtotal
						<input type="number" name="subtotal[]" readonly x-model="row.subtotal">
					</label>
				</div>
			</template>
			
			<br><br>
			<button type="button" x-on:click="rmRow">- Hapus</button>&nbsp;&nbsp;
			<button type="button" x-on:click="addRow">+ Tambah</button>

			<hr>

			<label >
				total
				<input type="number" name="total" readonly="" x-model="total" value="{{ $order->total }}">
			</label>
			<button>Order</button>

		</div>
	</form>

	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.min.js" defer></script>
	<script>
		function instance() {
			const intialRow={item_id:null,qty:0,price:0,subtotal:0};
			const items = @json($items);

			return {
				
				// data
				rows:@json($order->order_details),
				total:0,
				
				// methods
				addRow(){
					this.rows.push(Object.assign({},intialRow));
				},

				rmRow(){
					this.rows.pop();
					this.setTotal();
				},

				setPrice(id,index){
					const item=items.find(item => item.id ==id);
					const result=item ? item.price:null;

					this.rows[index].price=result;
					this.setSub(index);

				},

				setSub(index){
					const row=this.rows[index];
					if (row.price && row.qty) {
						const result =row.price * row.qty;

						row.subtotal=result;
						this.setTotal();
					}
				},

				setTotal(){
					let result =0;

					if (this.rows.length > 1) {
						 result=this.rows.reduce((total, row)=> (total + row.subtotal),0);
					}else if( this.rows.length == 1){
						result=this.rows[0].subtotal;
					}
							
					this.total=result;
				}

			}
		}

	</script>
</body>
</html>