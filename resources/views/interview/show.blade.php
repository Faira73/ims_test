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
        <div class="mt-6">
            <a href="{{ route('interview.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Back to List</a>
        </div>
    </div>
</x-layout>
