
    <form method="POST" action="{{ route('candidates.store') }}"
             enctype="multipart/form-data">
                {{ csrf_field() }}

    <h6 class="text-muted mb-3">Basic Information</h6>

    <div class="form-row">
        <div class="form-group col-md-3">
            <label>Title</label>
            <select name="title" class="form-control">
                <option value="">—</option>
                <option>Mr</option>
                <option>Mrs</option>
                <option>Miss</option>
                <option>Dr</option>
                <option>Hon</option>
                <option>Chief</option>
                <option>Engr</option>
                <option>Prof</option>
            </select>
        </div>

        <div class="form-group col-md-5">
            <label>Full Name *</label>
            <input type="text" name="name" class="form-control" required>
            <small class="text-muted">This will appear on the public profile</small>
        </div>

        <div class="form-group col-md-4">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="form-group col-md-6">
            <label>Gender</label>
            <select name="gender" class="form-control">
                <option value="">—</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>District / Constituency</label>
        <input type="text" name="district" class="form-control">
    </div>

    <div class="form-group">
        <label>State</label>
        <input type="text" name="state" class="form-control">
    </div>

    <div class="form-group">
        <label>Candidate Photo</label>
        <input type="file" name="photo" class="form-control-file" accept="image/*">
    </div>

    <hr>

    <h6 class="text-muted mb-3">Current Position</h6>

    <div class="form-row">
        <div class="form-group col-md-6 position-relative">
            <label>Position *</label>
            <input type="text" name="position" id="positionInput" class="form-control" autocomplete="off" required>
            <div id="positionSuggestions" class="list-group position-absolute w-100 d-none"></div>
            <small class="text-muted">Start typing to see common positions</small>
        </div>

        <div class="form-group col-md-3">
            <label>From</label>
            <input type="number" name="year_from" id="yearFrom" class="form-control" placeholder="2023">
        </div>

        <div class="form-group col-md-3">
            <label>To</label>
            <input type="number" name="year_until" id="yearUntil" class="form-control" placeholder="Present">
        </div>
    </div>

    <div id="positionPreview" class="alert alert-light small d-none"></div>

    <div class="text-right mt-4">
        <button type="submit" class="btn btn-primary">
            Save Candidate
        </button>
    </div>
</form>
