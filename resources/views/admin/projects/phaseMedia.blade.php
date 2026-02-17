@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800">Media Portal</h1>

    <div class="alert alert-info">
        This is the Media portal of <strong>{{ ucfirst($phase->status) }}</strong>.
        View all media in the
        <a href="{{ route('admin.projects.show', $project->id) }}">Full Project View</a>.
    </div>

    {{-- UPLOAD MEDIA --}}
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Upload Media</h6>
        </div>
        <div class="card-body">
            <form method="POST"
                  action="{{ route('admin.projects.addMedia') }}"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="phase_id" value="{{ $phase->id }}">

                <div id="mediaInputs">
<!-- In your blade file, update the file input -->
<input type="file" name="media[]" class="form-control mb-2" 
       accept="image/*,video/*" required>
                </div>

                <button type="button"
                        class="btn btn-sm btn-outline-secondary"
                        onclick="addMediaInput()">
                    + Add more
                </button>

                <button class="btn btn-primary mt-3">Upload</button>
            </form>
        </div>
    </div>

    {{-- MEDIA GRID --}}
    <div class="row">
        @foreach($media as $m)
            <div class="col-md-3 mb-3" id="media-{{ $m->id }}">
                <div class="card">

                    <div class="position-relative">

    @if(Str::endsWith($m->file_path, ['.mp4', '.mov', '.avi']))
        <video width="100%" controls>
            <source src="{{ asset('storage/'.$m->file_path) }}" type="video/mp4">
        </video>
    @else
        <img src="{{ asset('storage/'.$m->file_path) }}"
             class="img-fluid rounded">
    @endif

    <form method="POST"
          action="{{ route('admin.projects.media.delete', $m->id) }}"
          onsubmit="return confirm('Delete this media?')"
          class="position-absolute"
          style="top:8px; right:8px;">
        @csrf
        @method('DELETE')

        <button class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>

</div>


                    <div class="card-body text-center p-2">
                        <form method="POST"
                            action="{{ route('admin.projects.media.delete', $m->id) }}"
                            onsubmit="return confirm('Delete this media?')"
                            class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>


                    </div>

                </div>
            </div>
        @endforeach
    </div>

</div>

<script>
function addMediaInput() {
    const input = document.createElement('input');
    input.type = 'file';
    input.name = 'media[]';
    input.accept = 'image/*,video/*'; // Add this line
    input.className = 'form-control mb-2';
    document.getElementById('mediaInputs').appendChild(input);
}
</script>

<script>
document.getElementById('addMediaModal').addEventListener('hidden.bs.modal', () => {
    const container = document.getElementById('mediaInputs');
    container.innerHTML = '<input type="file" name="media[]" class="form-control mb-2" required>';
});
</script>

@endsection
