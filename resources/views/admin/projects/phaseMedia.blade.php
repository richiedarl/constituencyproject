@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800">Media Portal</h1>

    <div class="alert alert-info">
        This is the Media portal of <strong>{{ $phase->status }}</strong>.
        To view all media for this project, go to 
        <a href="{{ route('admin.projects.show', $project->id) }}">Full Project View</a>.
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Upload Media for this Phase</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.projects.addMedia') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="phase_id" value="{{ $phase->id }}">
                <div id="mediaInputs">
                    <div class="mb-2">
                        <input type="file" name="media[]" class="form-control" accept="image/*,video/*">
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="addMoreMedia">+ Add more</button>
                <button type="submit" class="btn btn-primary mt-3">Upload Media</button>
            </form>
        </div>
    </div>

    @if($media->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Existing Media</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($media as $m)
                    <div class="col-md-3 mb-3">
                       

        @if(Str::endsWith($m->file_path, ['.mp4', '.mov', '.avi']))
            <video width="100%" controls>
                <source src="{{ asset('storage/'.$m->file_path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @else
            <img src="{{ asset('storage/'.$m->file_path) }}" class="img-fluid rounded" alt="Media">
        @endif

                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>

<script>
document.getElementById('addMoreMedia').addEventListener('click', () => {
    const container = document.getElementById('mediaInputs');
    const div = document.createElement('div');
    div.classList.add('mb-2');
    div.innerHTML = '<input type="file" name="media[]" class="form-control" accept="image/*,video/*" required>';
    container.appendChild(div);
});
</script>
@endsection
