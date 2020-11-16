@php
	$isEdit=isset($order);
	$action=$isEdit ? route('order.update',$order->id) : route('order.store');
	$put=$isEdit ? method_field('PUT'):null; 
@endphp

<!DOCTYPE html>
<html>
<head>
	<title>create</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
</head>
<body>
	<h1>create</h1>

	<form action="{{ $action }}" method="post">
		@csrf
		{{ $put }}
		<div x-data="bambang()" x-init="()=>{initSelect()}">
			<label>
				Nama Pembeli
				<input type="text" name="customer_name" x-model="customer_name">
			</label>
			<br><br>
			<template x-for="(row ,index) in rows" :key="row">
				<div >
					<label>
						item
						<select class="select" :class="'row'+index" name="item_id[]" x-model="row.item_id"  style="display: none;">
							<option value="">-- pilih item --</option>
							@foreach ($items as $item)
								<option value="{{ $item->id }}">{{ $item->name }}</option>
							@endforeach
							<span x-text="row.item_id"></span>
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
				<input type="number" name="total" readonly="" x-model="total">
			</label>
			<button>Order</button>

		</div>
	</form>


	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.min.js" defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
	<script>

		function bambang() {
			const intialRow={item_id:null,qty:0,price:0,subtotal:0};
			const items = @json($items);

			return {
				
				// data

				@if($isEdit)
					rows:@json($order->order_details),
					total:{{ $order->total }},
					customer_name:'{{ $order->customer_name }}',
				@else
					rows:[Object.assign({},intialRow),],
					total:0,
					customer_name:'',
				@endif

				// methods
				initSelect(){
					$('.select').select2();
					
					this.rows.forEach((row,index)=>{

						$('.row'+index).on('select2:select',(e)=>{
							row.item_id = e.target.value
							this.setPrice(row.item_id,index)
						})
					})
				},

				addRow(){
					this.rows.push(Object.assign({},intialRow));
					this.$nextTick(()=>{ this.initSelect() });		
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