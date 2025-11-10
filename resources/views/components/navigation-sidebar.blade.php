<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/candidates/">Candidates</a></li>
    <li><a href="/employee/status/approved">Employees</a></li>
    
    @if (Auth::user() ?->is_admin)
        <li><a href="/employee/status/pending">Pending Employees</a></li>
    @endif
    
    <li><a href="/interviews">Interviews</a></li>
    <li><a href="/questions">Questions Bank</a></li>
</ul>