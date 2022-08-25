    <x-backend>
    	<main>
    		<div class="container-fluid px-4">
    			<div class="card my-4 headercard">
    				<div class="list-header px-3 py-2">
    					<div>
    						<h2 class="text-white"><i class="icofont-list"></i>User Role Permission Form</h2>
    					</div>
    					<div class="option-area">
    						<a href="{{route('userrolepermission.index')}}">
    							<i class="icofont-circled-left gobacktooltip">
    								<span class="gobacktooltiptext">Back</span>
    							</i>
    						</a>
    					</div>
    				</div>
    			</div>
    			<div class="card mb-4">
    				<div class="card-body">
    					<form action="{{route('userrolepermission.store')}}" method="POST">
    						@csrf
    						<div class="row">
    							@if(session('errorMsg') != NULL)
    							<div class="alert alert-warning alert-dismissible fade show" role="alert">
    								<strong>OPPS!</strong> {{session('errorMsg')}}
    								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    								</button>
    							</div>
    							@endif
    							<div class="col-md-6 text-white">
    								<label for="username" class="form-label">User Name</label>
    								<select name="userid" id="username" class="form-select">
    									<option>Select User</option>
    									@foreach($users as $user)
    									<option value="{{$user->id}}" class="option_select">{{$user->username}}</option>
    									@endforeach
    								</select>
    								<div class="text-danger form-control-feedback">
    									{{$errors->first('userid') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
    								</div>
    							</div>
    							<div class="col-md-6 text-white">
    								<label for=" rolename" class="form-label">Role Name</label>
    								<select name="roleid" id="rolename" class="form-select">
    									<option>Select Role</option>
    									@foreach($roles as $role)
    									<option value="{{$role->id}}">{{$role->name}}</option>
    									@endforeach
    								</select>
    								<div class="text-danger form-control-feedback">
    									{{$errors->first('roleid') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
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
    								<tbody id="result">
    									@foreach ($permissions as $permission)
    									@php
    									$id = $permission->id;
    									$name = $permission->name;

    									@endphp
    									<tr class="rolepermission">
    										<td>{{$name}} <input type="hidden" name="permissionname[{{$id}}]" value="{{$name}}">

    											<input type="hidden" name="permission_id[{{$id}}]" value="{{ $id }}">
    										</td>

    										<td>
    											<div>
    												<input type="hidden" name="create[{{$id}}]" value="no">
    												<input class="form-check-input" name="create[{{$id}}]" type="checkbox" value="yes" aria-label="...">
    											</div>
    										</td>
    										<td>
    											<div>
    												<input type="hidden" name="read[{{$id}}]" value="no">
    												<input class="form-check-input" name="read[{{$id}}]" type="checkbox" value="yes" aria-label="...">
    											</div>
    										</td>
    										<td>
    											<div>
    												<input type="hidden" name="update[{{$id}}]" value="no">
    												<input class="form-check-input" name="update[{{$id}}]" type="checkbox" value="yes" aria-label="...">
    											</div>
    										</td>
    										<td>
    											<div>
    												<input type="hidden" name="delete[{{$id}}]" value="no">
    												<input class="form-check-input" name="delete[{{$id}}]" type="checkbox" value="yes" aria-label="...">
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
    	@section('script_content')
    	<script type="text/javascript">
    		$(document).ready(function() {
    			$("#rolename").on('change', function() {
    				var roleid = $("#rolename").val();
    				// alert(roleid);
    				$.ajaxSetup({
    					headers: {
    						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    					}
    				})

    				$.post('/getrolepermission/' + roleid, {
    					data: roleid,
    				}, function(responses) {
    					// alert('Role id passed successfully');
    					// console.log(roleid);
    					$(".rolepermission").remove();

    				})

    				$.get('/getrolepermission/' + roleid, function(data) {
    					// console.log(data);
    					var rolepermissions = data.rolepermission;
    					var create = data.create;
    					var read = data.read;
    					var update = data.update;
    					var deletes = data.delete; //delete is not allowed to used as variable name in jquery
    					var permission = data.permission;
    					console.log(rolepermission, create, read, update, deletes, permission);
    					var rolepermission = '';
    					$.each(permission, function(i, v) {
    						var id = v.id;
    						var name = v.name;
    						rolepermission += `
                                            <tr class="rolepermission">
                                            <td>${name}<input type="hidden" name="permissionname[${id}]" value="${name}">

                                                <input type="hidden" name="permission_id[${id}]" value="${id}">
                                            </td>

                                            <td>
                                                <div>
                                                    <input type="hidden" name="create[${id}]" value="no">`;
    						if (jQuery.inArray(id, rolepermissions) !== -1 && create[id] == "yes") {
    							rolepermission += `<input class="form-check-input" name="create[${id}]" type="checkbox" value="yes" aria-label="..." checked>`;
    						} else {
    							rolepermission += `<input class="form-check-input" name="create[${id}]" type="checkbox" value="yes" aria-label="...">`;
    						}

    						rolepermission += `</div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type = "hidden" name = "read[${id}]" value = "no" >`;
    						if (jQuery.inArray(id, rolepermissions) !== -1 && read[id] == "yes") {
    							rolepermission += `<input class="form-check-input" name="read[${id}]" type="checkbox" value="yes"  aria-label="..." checked>`;
    						} else {
    							rolepermission += `<input class="form-check-input" name="read[${id}]" type="checkbox" value="yes"  aria-label="..." >`;
    						}

    						rolepermission += `</div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type = "hidden" name = "update[${id}]" value = "no" >`;
    						if (jQuery.inArray(id, rolepermissions) !== -1 && update[id] == "yes") {
    							rolepermission += `<input class="form-check-input" name="update[${id}]" type="checkbox" value="yes"  aria-label="..." checked>`;
    						} else {
    							rolepermission += `<input class="form-check-input" name="update[${id}]" type="checkbox" value="yes"  aria-label="..." >`;
    						}

    						rolepermission += `</div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type = "hidden" name = "delete[${id}]" value = "no" >`;
    						if (jQuery.inArray(id, rolepermissions) !== -1 && deletes[id] == "yes") {
    							rolepermission += `<input class="form-check-input" name="delete[${id}]" type="checkbox" value="yes"  aria-label="..." checked>`;
    						} else {
    							rolepermission += `<input class="form-check-input" name="delete[${id}]" type="checkbox" value="yes"  aria-label="..." >`;
    						}

    						rolepermission += `</div>
                                            </td>`
    					});
    					$('#result').html(rolepermission);
    				})
    			});
    		});
    	</script>
    	@endsection

    </x-backend>