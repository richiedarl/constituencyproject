@extends('layouts.admin')

@section('title', 'Edit Project')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Project</h1>
            <p class="text-muted mb-0">{{ $project->title }}</p>
        </div>

        <a href="{{ route('admin.projects.show', $project) }}"
           class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Project
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST"
                  action="{{ route('projects.update', $project) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- BASIC --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Project Title</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $project->title) }}"
                               required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Project Type</label>
                        <select name="type" class="form-control" required>
                            <option value="executing" @selected($project->type === 'executing')>
                                Executing
                            </option>
                            <option value="documenting" @selected($project->type === 'documenting')>
                                Documenting
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Short Description</label>
                    <textarea name="short_description"
                              class="form-control"
                              rows="2">{{ old('short_description', $project->short_description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Full Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description', $project->description) }}</textarea>
                </div>

                {{-- STATUS --}}
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            @foreach(['planning','ongoing','completed','cancelled'] as $status)
                                <option value="{{ $status }}"
                                    @selected($project->status === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Start Date</label>
                        <input type="date"
                               name="start_date"
                               class="form-control"
                               value="{{ optional($project->start_date)->format('Y-m-d') }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Completion Date</label>
                        <input type="date"
                               name="completion_date"
                               class="form-control"
                               value="{{ optional($project->completion_date)->format('Y-m-d') }}">
                    </div>
                </div>

                {{-- FINANCE --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Estimated Budget</label>
                        <input type="number"
                               name="estimated_budget"
                               class="form-control"
                               step="0.01"
                               value="{{ $project->estimated_budget }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Contractor Fee</label>
                        <input type="number"
                               name="actual_cost"
                               class="form-control"
                               step="0.01"
                               value="{{ $project->actual_cost }}">
                    </div>
                </div>

                {{-- FEATURED IMAGE --}}
                <hr>
                <label class="fw-bold">Featured Image</label>

                @if($project->featured_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$project->featured_image) }}"
                             class="img-thumbnail"
                             style="max-height:150px">
                    </div>
                @endif

                <input type="file"
                       name="featured_image"
                       class="form-control-file"
                       accept="image/*">

                {{-- MEDIA --}}
                <hr>
                <h6 class="text-muted mb-2">Add More Media</h6>

                <input type="file"
                       name="media[]"
                       class="form-control"
                       multiple
                       accept="image/*,video/*">

                <small class="text-muted">
                    Files will be added to the current active phase.
                </small>

                {{-- EXISTING MEDIA --}}
                <hr>
                <h6 class="fw-bold mb-2">Existing Media</h6>

                <div class="row">
                    @forelse($project->allMedia as $media)
                        <div class="col-md-3 mb-3">
                            <div class="card">

                                @if($media->file_type === 'image')
                                    <img src="{{ asset('storage/'.$media->file_path) }}"
                                         class="card-img-top"
                                         style="height:160px;object-fit:cover">
                                @else
                                    <video controls class="w-100" height="160">
                                        <source src="{{ asset('storage/'.$media->file_path) }}">
                                    </video>
                                @endif

                                <div class="card-body text-center p-2">
                                    <form method="POST"
                                          action="{{ route('admin.projects.media.delete', $media) }}"
                                          onsubmit="return confirm('Delete this media?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No media uploaded yet.</p>
                    @endforelse
                </div>

                {{-- VISIBILITY --}}
                <hr>
                <div class="form-check">
                    <input type="hidden" name="is_public" value="0">
                    <input type="checkbox"
                           name="is_public"
                           value="1"
                           class="form-check-input"
                           @checked($project->is_public)>
                    <label class="form-check-label">Public</label>
                </div>

                <div class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           class="form-check-input"
                           @checked($project->is_active)>
                    <label class="form-check-label">Active</label>
                </div>

                <div class="text-right mt-4">
                    <button class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
