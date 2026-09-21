@extends('layouts.app')

@section('title', 'Contractor Profile')

@section('content')
<section class="py-5 bg-light"><div class="container" style="max-width: 760px;"><div class="card border-0 shadow-sm rounded-4"><div class="card-body p-4 p-md-5">
    <h1 class="h3 mb-1">Contractor profile</h1><p class="text-muted mb-4">{{ $contractor->user?->name }}</p>
    <div class="alert alert-{{ $contractor->suspended ? 'danger' : ($contractor->verified ? 'success' : 'warning') }}" role="status">
        @if($contractor->suspended)
            This contractor account is suspended. {{ $contractor->suspension_reason }}
        @elseif($contractor->verified)
            <i class="bi bi-patch-check-fill me-1"></i> Verified contractor profile
        @else
            Verification pending. You can maintain your profile while an administrator reviews it.
        @endif
    </div>
    @if($contractor->photo)
        <img src="{{ asset('storage/'.$contractor->photo) }}" alt="{{ $contractor->user?->name }} contractor profile" class="rounded-circle mb-4" style="width:96px;height:96px;object-fit:cover;">
    @endif
    <form method="POST" action="{{ route('contractor.profile.update') }}" enctype="multipart/form-data">@csrf @method('PATCH')
        <div class="row g-3"><div class="col-md-6"><label class="form-label" for="phone">Phone</label><input class="form-control" id="phone" name="phone" value="{{ old('phone', $contractor->phone) }}"></div><div class="col-md-6"><label class="form-label" for="district">District</label><input class="form-control" id="district" name="district" value="{{ old('district', $contractor->district) }}"></div><div class="col-12"><label class="form-label" for="occupation">Specialization</label><input class="form-control" id="occupation" name="occupation" value="{{ old('occupation', $contractor->occupation) }}"></div><div class="col-12"><label class="form-label" for="bio">Biography</label><textarea class="form-control" id="bio" name="bio" rows="5">{{ old('bio', $contractor->bio) }}</textarea></div><div class="col-12"><label class="form-label" for="photo">Photo</label><input class="form-control" type="file" id="photo" name="photo" accept="image/*"></div></div>
        <button class="btn btn-success mt-4" type="submit">Save profile</button>
    </form>
</div></div></div></section>
@endsection
