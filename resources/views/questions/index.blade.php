<x-layout>
    <x-slot name='sidebar'>
        <x-navigation-sidebar/>
    </x-slot>
    <h1>Questions</h1>
    <div class="top-navigation">
        <button data-modal-target="addQuestion" class="btn-primary">Add Question</button>
        <button data-modal-target="addCategory" class="btn-primary">Add Category</button>
    </div>
    <div style="background-color: #F6F7F9">
        
    </div>









    {{-- button modals --}}
    <x-modal id="addQuestion" title="Add New Question" action="{{ route('questions.store') }}">
    <div class="form-group">
        <label>Question Text</label>
        <input type="text" name="text" required>
    </div>

    <div class="form-group">
        <label>Category</label>
        <select name="category_id"> 
            <option value="disabled selected">Select a category</option>
            @foreach ($categories as $id=>$name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    </x-modal>

    <x-modal id="addCategory" title="Add New Category" action="{{ route('categories.store') }}">
        <div class="form-group">
            <label>Category Name</label>
            <input type="text" name="name" required>
        </div>
    </x-modal>

    <div style="background-color: #F6F7F9; padding: 20px; margin-top: 20px;">
        @forelse($categories as $categoryId => $categoryName)
            <div style="background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h2 style="color: #333; margin-bottom: 15px; font-size: 1.5rem;">{{ $categoryName }}</h2>
                
                @php
                    $categoryQuestions = $questions->where('category_id', $categoryId);
                @endphp

                @if($categoryQuestions->count() > 0)
                    <ul style="list-style: none; padding: 0;">
                        @foreach($categoryQuestions as $question)
                            <li style="padding: 10px; border-bottom: 1px solid #eee; margin-bottom: 10px;">
                                {{ $question->text }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p style="color: #999; font-style: italic;">No questions in this category yet.</p>
                @endif
            </div>
        @empty
            <p style="text-align: center; color: #999;">No categories available. Add a category to get started!</p>
        @endforelse
    </div>
</x-layout>