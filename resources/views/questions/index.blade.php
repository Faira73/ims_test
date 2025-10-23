<x-layout>
    <x-slot name='sidebar'>
        <x-navigation-sidebar/>
    </x-slot>
    <h1>Questions</h1>
    <div class="top-navigation">
        <button onclick="openModal('addQuestion')">Add Question</button>
        <button onclick="openModal('addCategory')">Add Category</button>
    </div>
    <div style="background-color: #F6F7F9">
        
    </div>









    {{-- button modals --}}
    <x-modal id="addQuestion" title="Add New Question" action="{{ route('questions.store') }}">
        <label>Question Text</label>
        <input type="text" name="question_text" required>

        <label>Category</label>
        <select name="category_id">
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </x-modal>


</x-layout>