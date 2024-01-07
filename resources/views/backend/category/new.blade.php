<x-backend>
    <main>
        <div class="container-fluid px-4">
            <div class="card my-4 headercard">
                <div class="list-header px-3 py-2">
                    <div>
                        <h2 class="text-white"><i class="icofont-list"></i>Category Form</h2>
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
                    <form action="{{route('category.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="nameinput" class="col-sm-2 col-form-label text-white">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nameinput" name="name">
                                <div class="text-danger form-control-feedback">
                                    {{$errors->first('name') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="codenoinput" class="col-sm-2 col-form-label text-white">Code No.</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="codenoinput" name="category_code">
                                <div class="text-danger form-control-feedback">
                                    {{$errors->first('category_code') }} {{-- error array khan htae ka first array ko htoke chin --}}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="photoinput" class="col-sm-2 col-form-label text-white">Photo</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="photoinput" name="photo">
                                <div class="text-danger form-control-feedback">
                                    {{$errors->first('photo') }} {{-- error array khan htae ka first array ko htoke chin --}}
                                </div>
                            </div>
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