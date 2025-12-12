<x-layout>
    <x-slot name="sidebar">
        <x-navigation-sidebar />
    </x-slot>
    <h1>Employees ({{ ucfirst($status) }})</h1>

    @if($employees->isEmpty())
        <p>No employees found with status: {{ $status }}</p>
    @else
        <ul>
            @foreach ($employees as $employee)
                <li>
                    {{ $employee->name }} ({{ $employee->email }}) 
                </li>
            @endforeach
        </ul>
    @endif
</x-layout>
