<div class="candidate-info">
    <!-- Candidate Header -->
    <div class="d-flex align-items-center mb-4">
        <div class="me-4">
            <div class="rounded-circle overflow-hidden" style="width: 80px; height: 80px; border: 3px solid #29a221;">
                <img src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : asset('images/avatar.png') }}"
                     alt="{{ $candidate->name }}"
                     class="w-100 h-100"
                     style="object-fit: cover;">
            </div>
        </div>
        <div>
            <h3 class="fw-bold mb-1">{{ $candidate->name }}</h3>
            <p class="text-muted mb-0">
                <i class="bi bi-geo-alt-fill me-1" style="color: #29a221;"></i>
                {{ $candidate->district ?? '' }} {{ $candidate->state ? ', ' . $candidate->state : '' }}
            </p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        @php
            $totalProjects = $candidate->projects->count();
            $totalPhases = 0;
            $totalUpdates = 0;
            foreach($candidate->projects as $project) {
                $totalPhases += $project->phases->count();
                foreach($project->phases as $phase) {
                    $totalUpdates += $phase->updates->count();
                }
            }
        @endphp
        <div class="col-4">
            <div class="text-center p-2 rounded-3" style="background: rgba(41, 162, 33, 0.05);">
                <div class="small text-muted">Projects</div>
                <div class="fw-bold" style="color: #29a221;">{{ $totalProjects }}</div>
            </div>
        </div>
        <div class="col-4">
            <div class="text-center p-2 rounded-3" style="background: rgba(255, 193, 7, 0.05);">
                <div class="small text-muted">Phases</div>
                <div class="fw-bold" style="color: #ffc107;">{{ $totalPhases }}</div>
            </div>
        </div>
        <div class="col-4">
            <div class="text-center p-2 rounded-3" style="background: rgba(41, 162, 33, 0.05);">
                <div class="small text-muted">Updates</div>
                <div class="fw-bold" style="color: #29a221;">{{ $totalUpdates }}</div>
            </div>
        </div>
    </div>

    <!-- Bio -->
    @if($candidate->bio)
        <div class="mb-3 p-3 rounded-3" style="background: rgba(41, 162, 33, 0.03); border-left: 3px solid #29a221;">
            <p class="small mb-0">{{ $candidate->bio }}</p>
        </div>
    @endif

    <!-- Projects Preview -->
    <h6 class="fw-bold mb-3" style="color: #212529;">Projects Overview</h6>
    @foreach($candidate->projects->take(2) as $project)
        <div class="mb-3 p-2 rounded-3" style="background: #f8f9fa;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold small">{{ $project->title }}</span>
                <span class="badge" style="background: {{ $project->status === 'completed' ? '#29a221' : '#ffc107' }}; color: {{ $project->status === 'ongoing' ? '#212529' : 'white' }}; font-size: 0.6rem;">
                    {{ ucfirst($project->status) }}
                </span>
            </div>
            <div class="progress mb-1" style="height: 4px;">
                <div class="progress-bar" style="width: {{ $project->progress_percentage }}%; background: #29a221;"></div>
            </div>
            <small class="text-muted">{{ $project->phases->count() }} phases, {{ $project->phases->sum('updates.count') }} updates</small>
        </div>
    @endforeach

    @if($candidate->projects->count() > 2)
        <p class="text-center small text-muted mt-2">+ {{ $candidate->projects->count() - 2 }} more projects</p>
    @endif
</div>
