
<div id="{{ $id }}" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>{{ $title }}</h2>
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{ $slot }}
            <button type="submit">Submit</button>
        </form>
    </div>
</div>




