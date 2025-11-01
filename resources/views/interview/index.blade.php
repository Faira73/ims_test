<x-layout>
    <x-slot name="sidebar">
        <x-navigation-sidebar />
    </x-slot>

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Interviews</h1>
        <button id="openAddInterviewModal" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Add Interview
        </button>
    </div>


    <table class="candidates-table">
        <thead>
            <tr>
                <th>Candidate Name</th>
                <th>Mobile Number</th>
                <th>Evaluators</th>
                <th>Position</th>
                <th>Resume</th>
                <th>Details</th>
                <th>Final Score</th>
                <th>Evaluation Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($interviews as $interview)
                <tr>
                    <td>{{ $interview->candidate->name ?? 'N/A' }}</td>
                    <td>{{ $interview->candidate->phone ?? 'N/A' }}</td>
                    <td>
                        {{ $interview->interviewers->pluck('name')->implode(', ') ?: 'N/A' }}
                    </td>
                    <td>{{ $interview->candidate->position ?? 'N/A' }}</td>
                    <td>
                        @if ($interview->candidate->resume_url)
                            <a href="{{ asset('storage/' . $interview->candidate->resume) }}" target="_blank">View</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('interview.show', $interview->id) }}">View</a>
                    </td>
                    <td>{{ $interview->evaluations->avg('score') ?? 'N/A' }}</td>
                    <td>
                        <button class="toggle-details" data-id="{{ $interview->id }}">Expand</button>
                    </td>
                </tr>

                {{-- Hidden row for detailed evaluations --}}
                <tr id="details-{{ $interview->id }}" class="details-row" style="display: none;">
                    <td colspan="8">
                        <table class="details-table">
                            <thead>
                                <tr>
                                    <th>Evaluator</th>
                                    <th>Criteria</th>
                                    <th>Score</th>
                                    <th>Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($interview->evaluations as $evaluation)
                                    <tr>
                                        <td>{{ $evaluation->employee->name ?? 'N/A' }}</td>
                                        <td>{{ $evaluation->criteria ?? 'N/A' }}</td>
                                        <td>{{ $evaluation->score ?? 'N/A' }}</td>
                                        <td>{{ $evaluation->comments ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.querySelectorAll('.toggle-details').forEach(button => {
            button.addEventListener('click', () => {
                const detailsRow = document.getElementById('details-' + button.dataset.id);
                detailsRow.style.display = detailsRow.style.display === 'none' ? 'table-row' : 'none';
            });
        });
    </script>

<!-- Add Interview Modal -->
<div id="addInterviewModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeAddInterviewModal">&times;</span>
        <h2 style="margin-bottom: 20px;">Add New Interview</h2>

        <form action="{{ route('interview.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="candidate_id">Candidate</label>
                <select name="candidate_id" id="candidate_id">
                    @foreach ($candidates as $candidate)
                        <option value="{{ $candidate->id }}">{{ $candidate->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="interviewers">Interviewers</label>
                <div class="form-group">
                    <div style="max-height: 150px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 4px;">
                        @foreach ($employees as $employee)
                            <label style="display: block; margin-bottom: 5px;">
                                <input type="checkbox" name="interviewers[]" value="{{ $employee->id }}">
                                {{ $employee->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label for="scheduled_at">Date & Time</label>
                <input type="datetime-local" name="scheduled_at" id="scheduled_at">
            </div>

            <div class="form-group">
                <label for="link">Interview Link</label>
                <input type="url" name="link" id="link" placeholder="https://example.com">
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" rows="3"></textarea>
            </div>

            <button type="submit" class="btn-submit">Save Interview</button>
        </form>
    </div>
</div>

<script>
    const openModalBtn = document.getElementById('openAddInterviewModal');
    const closeModalBtn = document.getElementById('closeAddInterviewModal');
    const modal = document.getElementById('addInterviewModal');

    openModalBtn.addEventListener('click', () => modal.style.display = 'block');
    closeModalBtn.addEventListener('click', () => modal.style.display = 'none');
    window.addEventListener('click', (e) => {
        if (e.target === modal) modal.style.display = 'none';
    });
</script>

{{-- Modal JS --}}
<script>
    const openModalBtn = document.getElementById('openAddInterviewModal');
    const closeModalBtn = document.getElementById('closeAddInterviewModal');
    const modal = document.getElementById('addInterviewModal');

    openModalBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
</script>

</x-layout>
