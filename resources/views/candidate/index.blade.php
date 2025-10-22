<x-layout>
    <x-slot name="sidebar">
        <x-navigation-sidebar />
    </x-slot>
    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1>Candidates</h1>
    <div class="top-navigation">
        <select name="position" id="position" class="position-dropdown">
            <option value="" selected>All positions</option>
        </select>
        <div class="search-bar">
            <input type="text" placeholder="Search for a candidate.." class ="search-input">
        </div>
        <button id="openPopupBtn" class="btn-primary">Add new candidate</button>
    </div>


    <table class="candidates-table">
        <thead>
            <tr> 
                <th>Candidate Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>View Resume</th>
                <th>Position</th>
                <th>Added By</th>
            </tr>
        </thead>

        @foreach($candidates as $candidate)
        <tr class="candidate" data-candidate-id = "{{$candidate->id}}">

            <td>{{$candidate->name }}</td>
            <td>{{$candidate->email }}</td>
            <td>{{$candidate->phone }}</td>
            <td>{{$candidate->resume_url }}</td>
            <td>{{$candidate->position }}</td>
            <td>
                <span class="employee-toggle" data-target="employee-details-{{$candidate->id}}">
                    <span class="toggle-icon">▼</span>
                </span>
            </td>
        </tr>
        <tr id="employee-details-{{$candidate->id}}" class="employee-details hidden">
            <td colspan="5">
                <div style="padding: 10px;">
                    <p>{{ $candidate->employee->name }} ({{$candidate->employee->email}})</p>
                </div>
            </td>
        </tr>
    @endforeach
    </table>
    
    <!-- Popup Modal -->
    <div id="popupModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Candidate</h2>
        
        <form method="POST" action="{{ route('candidate.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="position">Position:</label>
                <input type="text" id="position" name="position" required>
            </div>
            <div class="form-group">
                <label for="Years of experience">Years of Experience</label>
                <input type="number" id="years-experience" name="years_experience" min='0' required>
            </div>
            <div class="form-group">
                <label for="resume">Resume:</label>
                <input type="file" id="resume" name="resume_url" accept=".pdf,.doc,.docx" required>
            </div>
            
            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>
</div>

    <script>
        // Get elements
        const modal = document.getElementById('popupModal');
        const btn = document.getElementById('openPopupBtn');
        const closeBtn = document.querySelector('.close');

        // Open modal
        btn.onclick = function() {
            modal.style.display = 'block';
        }

        // Close modal when X is clicked
        closeBtn.onclick = function() {
            modal.style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</x-layout>