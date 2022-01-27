    <x-backend>
        @php
        $id = $user->id;
        $profile = $user->profile;
        $first_name = $user->first_name;
        $last_name = $user->last_name;
        $email = $user->email;
        $username = $user->username;
        $phone = $user->phone;
        $address = $user->address;

        if($profile == null) {
        $profile = "Profile is not Uploaded";
        } else {
        $profile = $profile;
        }
        @endphp
        <main>
            <div class="container-fluid px-4">
                <div class="card my-4 headercard">
                    <div class="list-header px-3 py-2">
                        <div>
                            <h2 class="text-white"><i class="icofont-users-alt-2"></i>User Edit Form</h2>
                        </div>
                        <div class="option-area">
                            <a href="{{route('user.index')}}">
                                <i class="icofont-circled-left gobacktooltip">
                                    <span class="gobacktooltiptext">Back</span>
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <form class="row g-3 text-white" action="{{route('user.update',$id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="oldProfile" value="{{$profile}}">
                            <div class="col-md-4">
                                <label for="image-upload" class="form-label">Profile Picture</label>
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
                                        <img src="{{asset($profile)}}" class="img-fluid" id="profilepreview" alt="{{$profile}}">
                                    </div>
                                    <div class=" tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div id="image-preview">
                                            <label for="image-upload" class="form-label" id="image-label">Upload Profile</label>
                                            <input type="file" class="form-control" id="image-upload" name="profile">
                                            <div class="text-danger form-control-feedback">
                                                {{$errors->first('profile') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="first_name" value="{{$first_name}}">
                                    <div class="text-danger form-control-feedback">
                                        {{$errors->first('first_name') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="last_name" value="{{$last_name}}">
                                    <div class="text-danger form-control-feedback">
                                        {{$errors->first('Last_name') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
                                    </div>
                                </div>
                                <div>
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" rows="2" name="address"> {{$address}} </textarea>
                                    <div class="text-danger form-control-feedback">
                                        {{$errors->first('address') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="phonenumber" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phonenumber" name="phone" value="{{$phone}}">
                                <div class="text-danger form-control-feedback">
                                    {{$errors->first('phone') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{$email}}">
                                <div class="text-danger form-control-feedback">
                                    {{$errors->first('email') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{$username}}">
                                <div class="text-danger form-control-feedback">
                                    {{$errors->first('username') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control" id="password" name="password">
                                <div class="text-danger form-control-feedback">
                                    {{$errors->first('password') }} {{-- error a myar gyi htae ka ta khu pl htoke chin --}}
                                </div>
                            </div>

                            <div class="mb-3 col-12">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn savebtn">
                                        <i class="icofont-save"></i>
                                        Update
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
                $.uploadPreview({
                    input_field: "#image-upload", // Default: .image-upload
                    preview_box: "#image-preview", // Default: .image-preview
                    label_field: "#image-label", // Default: .image-label
                    label_default: "Upload Profile", // Default: Choose File
                    label_selected: "Change Profile", // Default: Change File
                    no_label: false // Default: false
                });
            });
        </script>
        @endsection
    </x-backend>