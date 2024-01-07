<form id="searchForm" action="{{ route('posts.search') }}" method="POST">
    @csrf

    <div class="d-flex flex-column align-items-center">
        <label for="search"></label>

        <div class="input-group">
            <input type="text" class="form-control" name="search" id="search" placeholder="Search lorcana cards..."
                   value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn custom-btn-outline-success">Search</button>
            </div>
        </div>

        <br>

        <div class="mb-4 col-6">
            <div class="btn-group" id="categoryCheckboxes">
                @foreach($categories as $category)
                    <input class="btn-check" name="searchCategory[]" type="checkbox"
                           id="category-{{$category->id}}" value="{{$category->id}}"
                        {{ in_array($category->id, (array) request('searchCategory', [])) ? 'checked' : '' }}>
                    <label class="btn custom-btn-outline-success category-label"
                           for="category-{{$category->id}}">{{$category->name}}</label>
                @endforeach

                <a href="{{ route('posts.index') }}" class="btn custom-btn-outline-success">All Cards</a>
            </div>
        </div>

    </div>
</form>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById('searchForm');
        const categoryCheckboxes = document.querySelectorAll('#categoryCheckboxes input');

        categoryCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                // Uncheck other checkboxes
                categoryCheckboxes.forEach(function (otherCheckbox) {
                    if (otherCheckbox !== checkbox) {
                        otherCheckbox.checked = false;
                    }
                });
                // Submit the form
                form.submit();
            });
        });
    });
</script>

