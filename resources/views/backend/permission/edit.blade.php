    <x-backend>
        @php
        $id = $permission->id;
        $name = $permission->name;
        @endphp

        @foreach($permissionPermissions as $permissionPermission)
        @php
        $update = $permissionPermission->update;
        @endphp
        @endforeach
        <main>
            <div class="container-fluid px-4">
                <div class="card my-4 headercard">
                    <div class="list-header px-3 py-2">
                        <div>
                            <h2 class="text-white"><i class="icofont-list"></i>Permission Form</h2>
                        </div>
                        <div class="option-area">
                            <a href="{{route('permission.index')}}">
                                <i class="icofont-circled-left gobacktooltip">
                                    <span class="gobacktooltiptext">Back</span>
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{route('permission.update',$id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 row">
                                <label for="nameinput" class="col-sm-2 col-form-label text-white">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nameinput" name="name" value="{{$name}}">
                                    <div class="text-danger form-control-feedback">
                                        {{$errors->first('name') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-sm-10">
                                    @if($update == 'yes')
                                    <button type="submit" class="btn savebtn">
                                        <i class="icofont-save"></i>
                                        Update
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </x-backend>