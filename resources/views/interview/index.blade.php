<x-layout>
    <x-slot name="sidebar">
        <x-navigation-sidebar />
    </x-slot>

    <h1>Interviews</h1>

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
                        <a href="{{ route('interview.index', $interview->id) }}">View</a>
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
</x-layout>
