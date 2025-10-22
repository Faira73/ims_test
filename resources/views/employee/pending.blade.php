<x-layout>
    <x-slot name="sidebar">
        <x-navigation-sidebar />
    </x-slot>

    <h1>Employees ({{ ucfirst($status) }})</h1>

    @if (session('success'))
        <div class="alert success-message">
            {{ session('success') }}
        </div>
    @endif

    <table class="pending-employee">
        <thead>
            <tr>
                <th>Name</th>
                <th>Job Title</th>
                <th>Action</th>
                <th>Date Created</th>
            </tr>
        </thead>    
            @foreach($employees as $employee)
                <tr id="employee-row-{{ $employee->id }}">
                    <td>{{ $employee->name }}</td>
                    <td>{{$employee->position}}</td>
                    <td>
                        <form action="/employee/{{ $employee->id }}}/status" method="POST" style="display:inline" >
                            @csrf 
                            <input type="hidden" name="status" value = "approved">
                            <button type="submit" class="approve-btn">Approve</button>
                        </form>

                        <form action="/employee/{{ $employee->id }}}/status" method="POST" style="display:inline">
                            @csrf 
                            <input type="hidden" name="status" value = "rejected">
                            <button type="submit" class="reject-btn">Reject</button>
                        </form>
                    </td>
                    <td> {{ $employee->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
    </table>
    {{-- <script>
    //event delegation 
    document.addEventListener('click', function(e) { //e is the event that triggered this 

        if (e.target.classList.contains('approve-btn')) {
            const employeeId = e.target.dataset.id;
            updateEmployeeStatus(employeeId, 'approved');
        }


        if (e.target.classList.contains('reject-btn')) {
            const employeeId = e.target.dataset.id;
            updateEmployeeStatus(employeeId, 'rejected');
        }
    });

    // Function to send status update to the backend
    function updateEmployeeStatus(id, status) {
        fetch(`/employee/${id}/status`, { //where does this reside? 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Employee  ${status}!`);

                const row = document.getElementById(`employee-row-${id}`);
                if (row) row.remove();
            }
        });
    }
</script> --}}

</x-layout>
