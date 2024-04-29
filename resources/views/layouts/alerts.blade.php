@if (isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="alert-body">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="alert-body">
            <i data-feather="info" class="mr-50 align-middle"></i>
            <span> {{ session('error') }} </span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="alert-body">
            <i data-feather="check"></i>
            <span> {{ session('success') }} </span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session()->has('msg'))
    <div class="alert alert-success fade show" role="alert">
        <div class="alert-body">
            <i data-feather="star"></i>
            <span> {{ session('msg') }} </span>
        </div>
    </div>
@endif

@push('footer')
    <script>
        setTimeout(function() {
            $('.alert-success').fadeOut();
        }, 4000);

    </script>
@endpush
