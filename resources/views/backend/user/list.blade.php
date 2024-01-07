<x-backend>
    <main>
        <div class="container-fluid px-4">
            <div class="card my-4 headercard">
                <div class="list-header px-3 py-2">
                    <div>
                        <h2 class="text-white"><i class="icofont-users-alt-2"></i>Users</h2>
                    </div>
                    <div class="option-area">
                        <a href="{{route('user.create')}}">
                            <i class='bx bxs-plus-square addnew addnewtooltip'>
                                <span class="addnewtooltiptext">Add New</span>
                            </i>
                        </a>
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
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Phone No.</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $i = 1;@endphp
                                @foreach($users as $user)
                                @php
                                $id = $user->id;
                                $fname = $user->first_name;
                                $lname = $user->last_name;
                                $email = $user->email;
                                $status = $user->status;
                                $phoneno = $user->phone;
                                $password = $user->password;
                                if($status == 0) {
                                $userstatus = "Active";
                                }
                                @endphp
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$fname}}</td>
                                    <td>{{$lname}}</td>
                                    <td>{{$email}}</td>
                                    @if ($status == 0){
                                    <td>
                                        {{$userstatus}}
                                    </td>
                                    }
                                    @else {
                                    <td>
                                        <form action="{{ route('userstatus',$id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">

                                            @csrf
                                            @method('PUT')

                                            <button class="btn btn-outline-primary" type="submit">
                                                <i class="icofont-close icofont-1x"></i> Activate
                                            </button>

                                        </form>
                                    </td>
                                    }
                                    @endif
                                    <td>{{$phoneno}}</td>
                                    <td><a href="{{route('user.edit',$id)}}" class="btn btn-info" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail & Update">
                                            <i class="icofont-info-circle"></i>
                                        </a>
                                        <form action=" {{route('user.destroy',$id)}} " method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete the item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit" class="btn btn-info" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                <i class="icofont-close icofont-1x"></i>
                                            </button>
                                        </form>
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