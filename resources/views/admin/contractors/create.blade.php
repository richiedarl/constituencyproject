@extends('layouts.admin')

@section('title', 'Add New Contractor')

@section('styles')
<style>
    .form-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .preview-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .avatar-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 600;
        border: 3px solid #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .skill-tag {
        display: inline-block;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 15px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0 5px 10px 0;
        cursor: pointer;
        transition: all 0.2s;
    }

    .skill-tag:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
    }

    .skill-tag i {
        margin-left: 8px;
        font-size: 0.8rem;
    }

    .suggested-skill {
        display: inline-block;
        background: #f0f0f0;
        color: #4b5563;
        padding: 6px 15px;
        border-radius: 25px;
        font-size: 0.9rem;
        margin: 0 5px 10px 0;
        cursor: pointer;
        transition: all 0.2s;
    }

    .suggested-skill:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('admin.contractors.index') }}" class="text-decoration-none mb-2 d-inline-block">
                <i class="fas fa-arrow-left me-2"></i>Back to Contractors
            </a>
            <h1 class="h3 mb-0 text-gray-800">Add New Contractor</h1>
            <p class="mb-0 text-muted">Create a new contractor profile</p>
        </div>
    </div>

    <form action="{{ route('admin.contractors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- User Selection Section -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-user-circle me-2 text-primary"></i>User Account
            </h5>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="user_id" class="form-label fw-bold">Select User <span class="text-danger">*</span></label>
                        <select class="form-select @error('user_id') is-invalid @enderror"
                                id="user_id"
                                name="user_id"
                                required>
                            <option value="">Choose a user...</option>
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Select the user account to associate with this contractor</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-id-card me-2 text-primary"></i>Personal Information
            </h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-bold">Phone Number</label>
                        <input type="text"
                               class="form-control @error('phone') is-invalid @enderror"
                               id="phone"
                               name="phone"
                               value="{{ old('phone') }}"
                               placeholder="+1234567890">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="district" class="form-label fw-bold">District/Location</label>
                        <input type="text"
                               class="form-control @error('district') is-invalid @enderror"
                               id="district"
                               name="district"
                               value="{{ old('district') }}"
                               placeholder="e.g., Central District">
                        @error('district')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="occupation" class="form-label fw-bold">Occupation</label>
                        <input type="text"
                               class="form-control @error('occupation') is-invalid @enderror"
                               id="occupation"
                               name="occupation"
                               value="{{ old('occupation') }}"
                               placeholder="e.g., Electrician, Plumber">
                        @error('occupation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Skills Section -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-code me-2 text-primary"></i>Skills & Expertise
            </h5>

            <div class="mb-3">
                <label class="form-label fw-bold">Skills</label>
                <div class="border rounded p-3 mb-3" id="skillsContainer">
                    @if(old('skills'))
                        @foreach(old('skills') as $skill)
                            @if($skill)
                                <span class="skill-tag">
                                    {{ $skill }}<i class="fas fa-times" onclick="removeSkill(this)"></i>
                                </span>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="input-group">
                    <input type="text" class="form-control" id="skillInput" placeholder="Enter a skill...">
                    <button class="btn btn-primary" type="button" onclick="addSkill()">
                        <i class="fas fa-plus"></i> Add Skill
                    </button>
                </div>
                <small class="text-muted">Type a skill and click Add or press Enter</small>
            </div>

            <div class="mt-3">
                <label class="form-label fw-bold">Suggested Skills</label>
                <div>
                    @php
                        $suggestedSkills = ['Plumbing', 'Electrical', 'Carpentry', 'Masonry', 'Welding', 'Painting', 'HVAC', 'Roofing', 'Landscaping', 'General Labor'];
                    @endphp

                    @foreach($suggestedSkills as $skill)
                        <span class="suggested-skill" onclick="addSuggestedSkill('{{ $skill }}')">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Hidden inputs for skills -->
            <div id="skillInputs">
                @if(old('skills'))
                    @foreach(old('skills') as $index => $skill)
                        @if($skill)
                            <input type="hidden" name="skills[]" value="{{ $skill }}" id="skill_{{ $index }}">
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Photo Section -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-camera me-2 text-primary"></i>Profile Photo
            </h5>

            <div class="row align-items-center">
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <div id="avatarPreview">
                        <div class="avatar-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="mb-3">
                        <label for="photo" class="form-label fw-bold">Upload Photo</label>
                        <input type="file"
                               class="form-control @error('photo') is-invalid @enderror"
                               id="photo"
                               name="photo"
                               accept="image/*"
                               onchange="previewImage(this)">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Allowed formats: JPG, PNG, GIF. Max size: 2MB</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approval Section -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-check-circle me-2 text-primary"></i>Approval Status
            </h5>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="approved" name="approved" value="1" {{ old('approved') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="approved">
                            Approve Contractor
                        </label>
                        <small class="d-block text-muted">Approved contractors can apply for projects and be assigned</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-end gap-2 mb-5">
            <a href="{{ route('admin.contractors.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Create Contractor
            </button>
        </div>
    </form>
</div>

<script>
    let skillCount = {{ old('skills') ? count(old('skills')) : 0 }};

    function addSkill() {
        const input = document.getElementById('skillInput');
        const skill = input.value.trim();

        if (skill === '') {
            alert('Please enter a skill');
            return;
        }

        // Add skill tag to container
        const container = document.getElementById('skillsContainer');
        const tag = document.createElement('span');
        tag.className = 'skill-tag';
        tag.innerHTML = `${skill}<i class="fas fa-times" onclick="removeSkill(this)"></i>`;
        container.appendChild(tag);

        // Add hidden input
        const hiddenContainer = document.getElementById('skillInputs');
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'skills[]';
        hidden.value = skill;
        hidden.id = 'skill_' + skillCount;
        hiddenContainer.appendChild(hidden);

        skillCount++;
        input.value = '';
        input.focus();
    }

    function removeSkill(element) {
        const tag = element.parentNode;
        const skill = tag.textContent.slice(0, -1); // Remove the × character

        // Remove the hidden input
        const hiddenInputs = document.querySelectorAll('input[name="skills[]"]');
        hiddenInputs.forEach(input => {
            if (input.value === skill) {
                input.remove();
            }
        });

        // Remove the tag
        tag.remove();
    }

    function addSuggestedSkill(skill) {
        // Check if skill already exists
        const existingSkills = document.querySelectorAll('input[name="skills[]"]');
        for (let input of existingSkills) {
            if (input.value === skill) {
                alert('This skill has already been added');
                return;
            }
        }

        // Add skill tag to container
        const container = document.getElementById('skillsContainer');
        const tag = document.createElement('span');
        tag.className = 'skill-tag';
        tag.innerHTML = `${skill}<i class="fas fa-times" onclick="removeSkill(this)"></i>`;
        container.appendChild(tag);

        // Add hidden input
        const hiddenContainer = document.getElementById('skillInputs');
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'skills[]';
        hidden.value = skill;
        hidden.id = 'skill_' + skillCount;
        hiddenContainer.appendChild(hidden);

        skillCount++;
    }

    function previewImage(input) {
        const preview = document.getElementById('avatarPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="preview-avatar" alt="Preview">`;
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.innerHTML = `
                <div class="avatar-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            `;
        }
    }

    // Allow Enter key to add skill
    document.getElementById('skillInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addSkill();
        }
    });
</script>
@endsection
