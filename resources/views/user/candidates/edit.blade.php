@extends('layouts.app')

@section('title', 'Edit Candidate Profile')

@section('content')
<section class="py-5 bg-light">
    <div class="container" style="max-width: 760px;">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <h1 class="h3 mb-4">Edit candidate profile</h1>
                <form method="POST" action="{{ route('user.candidates.update', $candidate) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6"><label for="phone" class="form-label">Phone</label><input id="phone" name="phone" class="form-control" value="{{ old('phone', $candidate->phone) }}" required></div>
                        <div class="col-md-6"><label for="gender" class="form-label">Gender</label><select id="gender" name="gender" class="form-select" required>@foreach(['male', 'female', 'other'] as $gender)<option value="{{ $gender }}" @selected(old('gender', $candidate->gender) === $gender)>{{ ucfirst($gender) }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label for="district" class="form-label">District</label><input id="district" name="district" class="form-control" value="{{ old('district', $candidate->district) }}" required></div>
                        <div class="col-md-6"><label for="state" class="form-label">State</label><input id="state" name="state" class="form-control" value="{{ old('state', $candidate->state) }}" required></div>
                        <div class="col-12"><label for="bio" class="form-label">Biography</label><textarea id="bio" name="bio" class="form-control" rows="5">{{ old('bio', $candidate->bio) }}</textarea></div>
                        <div class="col-12"><label for="photo" class="form-label">Profile photo</label><input id="photo" type="file" name="photo" class="form-control" accept="image/*"></div>
                    </div>
                    <div class="d-flex gap-2 mt-4"><button class="btn btn-success" type="submit">Save changes</button><a class="btn btn-outline-secondary" href="{{ route('user.candidates.dashboard') }}">Cancel</a></div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
