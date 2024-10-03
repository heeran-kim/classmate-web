@props(['rating'])

<!-- Component to display a star rating out of 5, including half stars -->
<small class="text-body-secondary">
    @for ($i=0; $i<5; $i++)
        @if ($i<floor($rating))
            <i class="bi bi-star-fill"></i>
        @elseif ($i < ceil($rating) && $rating - floor($rating) >= 0.5)
            <i class="bi bi-star-half"></i>
        @else
            <i class="bi bi-star"></i>
        @endif
    @endfor
</small>