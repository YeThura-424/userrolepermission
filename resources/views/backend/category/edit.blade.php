    <x-backend>
        @php
        $id = $category->id;
        $name = $category->name;
        $photo = $category->photo;
        $category_code = $category->category_code;
        @endphp

        @foreach($categoryPermissions as $categoryPermission)
        @php
        $update = $categoryPermission->update;
        @endphp
        @endforeach
        <main>
            <div class="container-fluid px-4">
                <div class="card my-4 headercard">
                    <div class="list-header px-3 py-2">
                        <div>
                            <h2 class="text-white"><i class="icofont-list"></i>Category Edit Form</h2>
                        </div>
                        <div class="option-area">
                            <a href="{{route('category.index')}}">
                                <i class="icofont-circled-left gobacktooltip">
                                    <span class="gobacktooltiptext">Back</span>
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{route('category.update',$id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="oldPhoto" value="{{$photo}}">
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
                                <label for="codenoinput" class="col-sm-2 col-form-label text-white">Code No.</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="codenoinput" name="category_code" value="{{$category_code}}">
                                    <div class="text-danger form-control-feedback">
                                        {{$errors->first('category_code') }} {{-- error array khan htae ka first array ko htoke chin --}}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="photoinput" class="col-sm-2 col-form-label text-white">Photo</label>
                                <div class="col-sm-10">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Old Photo</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">New Photo</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <img src="{{asset($photo)}}" class="img-fluid w-25 mt-2">
                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            <input type="file" id="photoinput" name="photo" class="form-control mt-2">
                                            <div class="text-danger form-control-feedback">
                                                {{$errors->first('photo') }} {{-- error array khan htae ka first array ko htoke chin --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-sm-10">
                                    @if($update == "yes")
                                    <button type="submit" class="btn savebtn">
                                        <i class="icofont-save"></i>
                                        Save
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