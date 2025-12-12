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

        {{-- Check if current user is one of the interviewers --}}
        @if($interview->interviewers->contains(auth()->user()->id))
            <h2 class="text-xl font-semibold mb-4">Your Evaluation</h2>

            <form action="{{ route('evaluation.store', $interview->id) }}" method="POST">
                @csrf
                <table class="table-auto w-full border-collapse mb-6">
                    <thead>
                        <tr>
                            <th class="text-left p-2 border">Criteria</th>
                            <th class="text-left p-2 border">Description</th>
                            <th class="text-left p-2 border">Rating</th>
                            <th class="text-left p-2 border">Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluationCriteria as $criteria)
                            <tr>
                                <td class="p-2 border">{{ $criteria->label }}</td>
                                <td class="p-2 border">{{ $criteria->description }}</td>
                                <td class="p-2 border">
                                    <input type="number" name="ratings[{{ $criteria->id }}]" min="1" max="5"
                                        value="{{ old('ratings.'.$criteria->id) }}" class="border rounded p-1 w-16">
                                </td>
                                <td class="p-2 border">
                                    <input type="text" name="comments[{{ $criteria->id }}]" class="border rounded p-1 w-full">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Submit Evaluation</button>
            </form>
        @endif

        <div class="mt-6">
            <a href="{{ route('interview.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Back to List</a>
        </div>
    </div>
</x-layout>
