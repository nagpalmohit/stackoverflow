@if(session('success'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">x</span>
            <span class="sr-only">Close</span>
        </button>
        {{ session('success') }}
    </div>
@endif