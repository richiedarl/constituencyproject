@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Candidate</h1>
    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('candidates.update', $candidate) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-6"><label for="name">Name</label><input id="name" name="name" class="form-control" value="{{ old('name', $candidate->name) }}" required></div>
                    <div class="form-group col-md-6"><label for="email">Email</label><input id="email" type="email" name="email" class="form-control" value="{{ old('email', $candidate->email) }}" required></div>
                    <div class="form-group col-md-6"><label for="phone">Phone</label><input id="phone" name="phone" class="form-control" value="{{ old('phone', $candidate->phone) }}"></div>
                    <div class="form-group col-md-6"><label for="gender">Gender</label><select id="gender" name="gender" class="form-control"><option value="">Not specified</option>@foreach(['male', 'female', 'other'] as $gender)<option value="{{ $gender }}" @selected(old('gender', $candidate->gender) === $gender)>{{ ucfirst($gender) }}</option>@endforeach</select></div>
                    <div class="form-group col-md-6"><label for="district">District</label><input id="district" name="district" class="form-control" value="{{ old('district', $candidate->district) }}" required></div>
                    <div class="form-group col-md-6"><label for="state">State</label><input id="state" name="state" class="form-control" value="{{ old('state', $candidate->state) }}" required></div>
                    <div class="form-group col-12"><label for="bio">Biography</label><textarea id="bio" name="bio" class="form-control" rows="5">{{ old('bio', $candidate->bio) }}</textarea></div>
                    <div class="form-group col-12"><label for="photo">Photo</label><input id="photo" type="file" name="photo" class="form-control-file" accept="image/*"></div>
                    <div class="form-group col-12"><div class="form-check"><input id="approved" type="checkbox" name="approved" value="1" class="form-check-input" @checked(old('approved', $candidate->approved))><label for="approved" class="form-check-label">Approved for public display</label></div></div>
                </div>
                <button class="btn btn-primary" type="submit">Save changes</button>
                <a class="btn btn-secondary" href="{{ route('candidates.show', $candidate) }}">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
