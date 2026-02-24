<!-- Wallet Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="text-muted mb-1">Wallet Balance</h5>
                    <h2 class="font-weight-bold text-dark">
                        ₦{{ number_format($walletBalance ?? 0, 2) }}
                    </h2>
                </div>

                <div class="d-flex">
                    @if(auth()->user()->contributor)
                        <a href="{{ route('wallet.fund') }}" class="btn btn-success btn-lg mr-2">
                            <i class="fas fa-plus-circle"></i> Fund Now
                        </a>
                    @endif

                    <a href="{{ route('wallet.transactions') }}" class="btn btn-outline-dark btn-lg">
                        <i class="fas fa-history"></i> View Transactions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Generate Report Button -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        @if(auth()->user()->admin)
            Admin Dashboard
        @elseif(auth()->user()->contractor)
            Contractor Dashboard
        @elseif(auth()->user()->contributor)
            Contributor Dashboard
        @else
            Dashboard
        @endif
    </h1>

    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#reportModal">
        <i class="fas fa-download fa-sm text-white-50"></i>
        Generate Report
    </a>
</div>

<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('report.generate') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Generate Candidate Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="candidate_id">Select Candidate</label>
                        <select name="candidate_id" id="candidate_id" class="form-control" required>
                            <option value="">Choose candidate...</option>
                            @forelse($candidates ?? [] as $candidate)
                                <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                            @empty
                                <option value="" disabled>No approved candidates available</option>
                            @endforelse
                        </select>
                        @if(empty($candidates) || count($candidates) == 0)
                            <small class="text-muted">No approved candidates found. Please check back later.</small>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" {{ empty($candidates) ? 'disabled' : '' }}>
                        Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
