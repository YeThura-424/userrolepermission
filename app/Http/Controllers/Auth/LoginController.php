<?php
namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\JsonResponse;
    use App\Providers\RouteServiceProvider;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Http\Request;
    use Spatie\Permission\Models\Role;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Validation\ValidationException;
    use Illuminate\Http\Response;
    use App\Models\User;

    class LoginController extends Controller
    {
        /*
        |--------------------------------------------------------------------------
        | Login Controller
        |--------------------------------------------------------------------------
        |
        | This controller handles authenticating users for the application and
        | redirecting them to your home screen. The controller uses a trait
        | to conveniently provide its functionality to your applications.
        |
        */

        use AuthenticatesUsers;

        /**
         * Where to redirect users after login.
         *
         * @var string
         */
        protected $redirectTo = RouteServiceProvider::HOME;

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }

        // public function index()
        // {
        //     return view('auth.login');
        // }

        public function username()
        {
            return 'username';
        }

        protected function sendLockoutResponse(Request $request)
        {
            $status = 1;
            $username = $request->username;
            $user = User::where('username', $username)->first();
            // dd($user);
            $user->status = $status;
            $user->save();

            throw ValidationException::withMessages([
                $this->username() => [trans('auth.throttle', [])],
            ])->status(Response::HTTP_TOO_MANY_REQUESTS);
        }

        protected function authenticated($request, $user)
        {
            $role = Role::all()->pluck('name')->toArray();
            // dd($role);
            if ($user->hasAnyRole($role) && $user->status == 0) {
                // dd("Have both role and active");
                return redirect('/category');
            }
            if (!$user->hasAnyRole($role) && $user->status == 1) {
                // dd("Doesn't have both role and active");
                Auth::logout();
                return redirect::back()->with("errorMsg", "User is currently not active and does not have any role");
            }
            if ($user->status == 1) {
                // dd("User is not active");
                Auth::logout();
                return redirect::back()->with("errorMsg", "User is currently not active");
            }
            if (!$user->hasAnyRole($role)) {
                // dd("User does not have any role");
                Auth::logout();
                return redirect::back()->with("errorMsg", "User does not have any role");
            }
        }

        public function logout(Request $request)
        {
            $this->guard()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            if ($response = $this->loggedOut($request)) {
                return $response;
            }

            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect('/login');
        }
    }
