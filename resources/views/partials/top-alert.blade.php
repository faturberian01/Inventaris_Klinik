@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center rounded-0 m-0" role="alert">
    <span data-feather="check-circle" class="align-text-middle me-2"></span>
    <div>
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

@if (session()->has('failed'))
<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center rounded-0 m-0" role="alert">
    <span data-feather="x-octagon" class="align-text-middle me-2"></span>
    <div>
        {{ session('failed') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif