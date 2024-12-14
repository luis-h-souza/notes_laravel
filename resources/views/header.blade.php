
<div class="row mb-3 align-items-center">
    <div class="col">
        <a href="{{ route('home') }}">
            <img src="{{asset('assets/images/logo.png')}}" alt="logo do app Notes">
        </a>
    </div>

    <div class="col">
        <div class="d-flex justify-content-end align-items-center">
            <span class="me-5"><i
                    class="fa-solid fa-user-circle fa-lg text-secondary me-1"></i>{{ session('user.username') }}</span>
            <a href="{{ route('logout') }}" class="btn btn-outline-secondary px-3">
                Logout<i class="fa-solid fa-arrow-right-from-bracket ms-2"></i>
            </a>
        </div>
    </div>
</div>

<hr>
