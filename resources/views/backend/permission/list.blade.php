<x-backend>
    @foreach($permissionPermissions as $permissionPermission)
    @php
    $create = $permissionPermission->create;
    $read = $permissionPermission->read;
    $update = $permissionPermission->update;
    $delete = $permissionPermission->delete;
    @endphp
    @endforeach
    <main>
        <div class="container-fluid px-4">
            <div class="card my-4 headercard">
                <div class="list-header px-3 py-2">
                    <div>
                        <h2 class="text-white"><i class="icofont-list"></i>Permission</h2>
                    </div>
                    <div class="option-area">
                        @if($create == 'yes')
                        <a href="{{route('permission.create')}}">
                            <i class='bx bxs-plus-square addnew addnewtooltip'>
                                <span class="addnewtooltiptext">Add New</span>
                            </i>
                        </a>
                        @endif
                        <a href="">
                            <i class='bx bx-filter filtersearch filtersearchtooltip'>
                                <span class="filtersearchtooltiptext">Filter</span>
                            </i>
                        </a>
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
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($permissions as $permission)
                                @php
                                $name = $permission->name;
                                $id = $permission->id;
                                @endphp
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$name}}</td>
                                    <td><a href="{{route('permission.edit',$id)}}" class="btn btn-warning">
                                            <i class="icofont-ui-settings icofont-1x"></i>
                                        </a>
                                        @if($delete == 'yes')
                                        <form action="{{route('permission.destroy',$id)}}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete the item?')">
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
</x-backend>