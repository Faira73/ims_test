<h1>Candidate Details</h1>

<p>Name: {{ $candidate->name }}</p>
<p>Email: {{ $candidate->email }}</p>
<p>Phone Number: {{$candidate->phone}}</p> 
<p>Years of Experience: {{$candidate->years_experience}}</p>
<p>Position: {{$candidate->position}}</p>
<p>Added by: {{ $candidate->employee->name }} ({{ $candidate->employee->email }})</p>

