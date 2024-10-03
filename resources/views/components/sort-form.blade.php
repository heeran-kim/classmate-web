@props(['assessment', 'sort'])

<!-- Component for displaying a sort dropdown menu -->
<form id="sortForm" method="GET" action="{{ route('assessment.review.index', ['assessment' => $assessment->id]) }}">
    <select id="sortSelect" class="form-select" name="sort">
        <option value="rating-desc" {{ $sort == "rating-desc" ? "selected" : "" }}>Highest Rated</option>
        <option value="rating-asc" {{ $sort == "rating-asc" ? "selected" : "" }}>Lowest Rated</option>
        <option value="reviews-desc" {{ $sort == "reviews-desc" ? "selected" : "" }}>Most Reviews</option>
        <option value="reviews-asc" {{ $sort == "reviews-asc" ? "selected" : "" }}>Fewest Reviews</option>
    </select>
</form>

<script>
    const select = document.getElementById("sortSelect");
    const form = document.getElementById("sortForm");
    select.addEventListener("change", submitForm);
    function submitForm(e) {
        form.submit();
    }
</script>
