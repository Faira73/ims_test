<x-layout>
    <x-slot name="sidebar">
        <x-navigation-sidebar />
    </x-slot>

    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Interview Details</h1>

        <table class="table-auto w-full border-collapse mb-6">
            <tbody>
                <tr>
                    <th class="text-left p-2 border w-1/3">Candidate Name</th>
                    <td class="p-2 border">{{ $interview->candidate->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Mobile Number</th>
                    <td class="p-2 border">{{ $interview->candidate->phone ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Evaluators</th>
                    <td class="p-2 border">
                        {{ $interview->interviewers->pluck('name')->implode(', ') ?: 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Position</th>
                    <td class="p-2 border">{{ $interview->candidate->position ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Date</th>
                    <td class="p-2 border">
                        {{ $interview->scheduled_at ? \Carbon\Carbon::parse($interview->scheduled_at)->format('d M Y') : 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Time</th>
                    <td class="p-2 border">
                        {{ $interview->scheduled_at ? \Carbon\Carbon::parse($interview->scheduled_at)->format('h:i A') : 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Status</th>
                    <td class="p-2 border">{{ ucfirst($interview->status) ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="text-left p-2 border">Notes</th>
                    <td class="p-2 border">{{ $interview->notes ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <h2 class="text-xl font-semibold mb-2">Evaluations</h2>
        <table class="table-auto w-full border-collapse">
            <thead>
                <tr>
                    <th class="p-2 border">Evaluator</th>
                    <th class="p-2 border">Criteria</th>
                    <th class="p-2 border">Score</th>
                    <th class="p-2 border">Comments</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($interview->evaluations as $evaluation)
                    <tr>
                        <td class="p-2 border">{{ $evaluation->evaluator->name ?? 'N/A' }}</td>
                        <td class="p-2 border">{{ $evaluation->criteria ?? 'N/A' }}</td>
                        <td class="p-2 border">{{ $evaluation->score ?? 'N/A' }}</td>
                        <td class="p-2 border">{{ $evaluation->comments ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-2 border text-gray-500">No evaluations yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            <a href="{{ route('interview.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Back to List</a>
        </div>
    </div>
</x-layout>
