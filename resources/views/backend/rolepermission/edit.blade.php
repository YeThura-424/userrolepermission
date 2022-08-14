    <x-backend>
    	@php
    	$roleid = $role->id;
    	$rolename = $role->name;
    	@endphp


    	<main>
    		<div class="container-fluid px-4">
    			<div class="card my-4 headercard">
    				<div class="list-header px-3 py-2">
    					<div>
    						<h2 class="text-white"><i class="icofont-list"></i>Role Permission Edit Form</h2>
    					</div>
    					<div class="option-area">
    						<a href="{{route('rolepermission.index')}}">
    							<i class="icofont-circled-left gobacktooltip">
    								<span class="gobacktooltiptext">Back</span>
    							</i>
    						</a>
    					</div>
    				</div>
    			</div>
    			<div class="card mb-4">
    				<div class="card-body">
    					<form action="{{route('rolepermission.update',$roleid)}}" method="POST">
    						@method('PUT')
    						@csrf
    						<!-- @method('PUT') -->
    						<div class="mb-3 row">
    							<label for="nameinput" class="col-sm-2 col-form-label text-white">Role Name</label>
    							<div class="col-sm-10">
    								<input type="text" class="form-control" id="nameinput" name="name" value="{{$rolename}}">
    								<div class="text-danger form-control-feedback">
    									{{$errors->first('name') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
    								</div>
    							</div>
    						</div>
    						<div class="card permission-card my-4">
    							<div class="card-header text-white">
    								<h4>Permission</h4>
    							</div>
    							<table class="table table-striped permission-table">
    								<thead class="permission-table-head">
    									<tr>
    										<th scope="col">Module</th>
    										<th scope="col">Create</th>
    										<th scope="col">Read</th>
    										<th scope="col">Update</th>
    										<th scope="col">Delete</th>
    									</tr>
    								</thead>
    								<tbody>
    									@foreach ($permissions as $permission)

    									@php
    									$i = 0;
    									$id = $permission->id;
    									$name = $permission->name;
    									@endphp

    									<tr>
    										<td>{{$name}} <input type="hidden" name="permissionname[{{$id}}]" value="{{$name}}">

    											<input type="hidden" name="permission_id[{{$id}}]" value="{{ $id }}">
    										</td>


    										<td>
    											<div>
    												<input type="hidden" name="create[{{$id}}]" value="no">
    												<input class="form-check-input" name="create[{{$id}}]" type="checkbox" value="yes" aria-label="..." @if (in_array($permission->id,$rolepermissions) && $create[$id]== "yes") checked @endif>
    											</div>
    										</td>
    										<td>
    											<div>
    												<input type="hidden" name="read[{{$id}}]" value="no">
    												<input class="form-check-input" name="read[{{$id}}]" type="checkbox" value="yes" aria-label="..." @if (in_array($permission->id,$rolepermissions) && $read[$id]== "yes") checked @endif>
    											</div>
    										</td>
    										<td>
    											<div>
    												<input type="hidden" name="update[{{$id}}]" value="no">
    												<input class="form-check-input" name="update[{{$id}}]" type="checkbox" value="yes" aria-label="..." @if (in_array($permission->id,$rolepermissions) && $update[$id]== "yes") checked @endif>
    											</div>
    										</td>
    										<td>
    											<div>
    												<input type="hidden" name="delete[{{$id}}]" value="no">
    												<input class="form-check-input" name="delete[{{$id}}]" type="checkbox" value="yes" aria-label="..." @if (in_array($permission->id,$rolepermissions) && $delete[$id]== "yes") checked @endif>
    											</div>
    										</td>



    									</tr>
    									@endforeach
    								</tbody>
    							</table>
    						</div>
    						<div class="mb-3 row">
    							<div class="col-sm-10">
    								<button type="submit" class="btn savebtn">
    									<i class="icofont-save"></i>
    									Save
    								</button>
    							</div>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    	</main>
    </x-backend>