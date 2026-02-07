@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4">Add Candidate</h1>

    <div class="card shadow">
        <div class="card-body">



                @include('admin.candidates.partials.form')


        </div>
    </div>

</div>
<script>
    const positions = [
        "Member, House of Representatives",
        "Senator",
        "Governor",
        "Deputy Governor",
        "Commissioner",
        "Local Government Chairman",
        "Councillor",
        "Special Adviser",
        "Special Assistant",
        "Minister",
        "Permanent Secretary"
    ];

    const positionInput = document.getElementById('positionInput');
    const suggestionsBox = document.getElementById('positionSuggestions');
    const previewBox = document.getElementById('positionPreview');

    positionInput.addEventListener('input', () => {
        const query = positionInput.value.toLowerCase();
        suggestionsBox.innerHTML = '';

        if (!query) {
            suggestionsBox.classList.add('d-none');
            return;
        }

        const matches = positions.filter(p => p.toLowerCase().includes(query));

        if (!matches.length) {
            suggestionsBox.classList.add('d-none');
            return;
        }

        matches.forEach(position => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action';
            item.textContent = position;

            item.onclick = () => {
                positionInput.value = position;
                suggestionsBox.classList.add('d-none');
                updatePreview();
            };

            suggestionsBox.appendChild(item);
        });

        suggestionsBox.classList.remove('d-none');
    });

    document.getElementById('yearFrom').addEventListener('input', updatePreview);
    document.getElementById('yearUntil').addEventListener('input', updatePreview);

    function updatePreview() {
        const position = positionInput.value;
        const from = document.getElementById('yearFrom').value;
        const until = document.getElementById('yearUntil').value || 'Present';

        if (!position || !from) {
            previewBox.classList.add('d-none');
            return;
        }

        previewBox.textContent = `Current Position: ${position} (${from} – ${until})`;
        previewBox.classList.remove('d-none');
    }

    document.addEventListener('click', (e) => {
        if (!positionInput.contains(e.target)) {
            suggestionsBox.classList.add('d-none');
        }
    });
</script>

@endsection
