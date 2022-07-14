    <x-backend>
    	@foreach($categoryPermissions as $categoryPermission)
    	@php
    	$create = $categoryPermission->create;
    	$read = $categoryPermission->read;
    	$update = $categoryPermission->update;
    	$delete = $categoryPermission->delete;
    	@endphp
    	@endforeach
    	<main>
    		<div class="container-fluid px-4">
    			<div class="card my-4 headercard">
    				<div class="list-header px-3 py-2">
    					<div>
    						<h2 class="text-white"><i class="icofont-list"></i>Category</h2>
    					</div>
    					<div class="option-area">
    						@if($create == 'yes')
    						<a href="{{route('category.create')}}">
    							<i class='bx bxs-plus-square addnew addnewtooltip'>
    								<span class="addnewtooltiptext">Add New</span>
    							</i>
    						</a>
    						@endif
    						<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    							<i class='bx bx-filter filtersearch filtersearchtooltip'>
    								<span class="filtersearchtooltiptext">Filter</span>
    							</i>
    						</a>
    						<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    							<div class="modal-dialog modal-dialog-centered">
    								<div class="modal-content">
    									<div class="modal-header">
    										<h5 class="modal-title" id="staticBackdropLabel">Filter</h5>
    										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    									</div>
    									<div class="modal-body">
    										<div class="row g-3">
    											<div class="col-md-6">
    												<label for="category_name" class="form-label">Category Name</label>
    												<input type="text" class="form-control" name="category_name" id="category_name">
    											</div>
    											<div class="col-md-6">
    												<label for="category_code" class="form-label">Category Code</label>
    												<input type="text" class="form-control" name="category_code" id="category_code">
    											</div>
    										</div>
    									</div>
    									<div class="modal-footer">
    										<button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="icofont-close icofont-1x"></i>Close</button>
    										<button type="submit" class="btn savebtn" id="filtersearch" data-bs-dismiss="modal">
    											<i class="icofont-save"></i>
    											Save
    										</button>
    									</div>
    								</div>
    							</div>
    						</div>
    						<a href="">
    							<i class='bx bxs-file exceldownload exceldownloadtooltip'>
    								<span class="exceldownloadtooltiptext">Export Excel</span>
    							</i>
    						</a>
    						<a href="">
    							<i class='bx bxs-file-pdf pdfdownload pdfdownloadtooltip'>
    								<span class="pdfdownloadtooltiptext">Export PDF</span>
    							</i>
    						</a>
    					</div>
    				</div>
    			</div>
    			<div class="card mb-4">
    				<div class="card-body">
    					<div class="tile-body">
    						@if(session('successMsg') != NULL)
    						<div class="alert alert-success alert-dismissible fade show" role="alert">
    							<strong>SUCCESS!</strong> {{session('successMsg')}}
    							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    							</button>
    						</div>
    						@endif
    						<table id="datatablesSimple">
    							<thead>
    								<tr>
    									<th>No.</th>
    									<th>Photo</th>
    									<th>Name</th>
    									<th>Code No.</th>
    									<th>Actions</th>
    								</tr>
    							</thead>

    							<tbody id="filter_data">
    								@php $i = 1; @endphp
    								@foreach($categories as $category)
    								@php
    								$id = $category->id;
    								$name = $category->name;
    								$category_code = $category->category_code;
    								$photo = $category->photo;
    								@endphp
    								<tr>
    									<td>{{$i++}}</td>
    									<td><img src="{{asset($photo)}}" class="img-fluid" style="width: 170px; object-fit: cover;"></td>
    									<td>{{$name}}</td>
    									<td>{{$category_code}}</td>
    									<td><a href="{{route('category.edit',$id)}}" class="btn btn-warning">
    											<i class="icofont-ui-settings icofont-1x"></i>
    										</a>
    										@if($delete == "yes")
    										<form action=" {{route('category.destroy',$id)}} " method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete the item?')">
    											@csrf
    											@method('DELETE')
    											<button class="btn btn-outline-danger" type="submit"><i class="icofont-close icofont-1x"></i></button>
    										</form>
    										@endif
    									</td>
    								</tr>
    								@endforeach
    							</tbody>
    						</table>
    					</div>
    				</div>
    			</div>
    	</main>
    	@section('script_content')
    	<script type="text/javascript">
    		$('#filtersearch').click(function() {
    			var category_name = $('#category_name').val();
    			var category_code = $('#category_code').val();
    			// alert(category_name)
    			$.ajaxSetup({
    				headers: {
    					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    				}
    			})

    			$.get('/categorysearch', {
    					category_name: category_name,
    					category_code: category_code
    				},
    				function(data) {
    					$('#filter_data').html(data);
    					// $('#staticBackdrop').hide();
    				})
    		})
    	</script>
    	@endsection
    </x-backend>