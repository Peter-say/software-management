<div class="col-xl-6">
    <div class="card">
        <div class="card-header border-0 pb-0">
            <h4 class="fs-20">Recent Booking Schedule</h4>
        </div>
        <div class="card-body pb-2 loadmore-content" id="BookingContent">
            <div class="text-center event-calender border-bottom booking-calender">
                <input type='text' class="form-control d-none " id='datetimepicker1' />
            </div>
            @foreach ($recent_room_reservations as $recent)
                <div class="rooms mt-3 d-flex align-items-center justify-content-between flex-wrap">
                    <div class="d-flex align-items-center mb-3">
                        <a href="{{ $recent->room->RoomImage() }}" data-fancybox="gallery_{{ $recent->room->id }}"
                            data-caption="{{ $recent->room->name }}">
                            <img class="me-3 rounded img-thumbnail" src="{{ $recent->room->RoomImage() }}"
                                alt="{{ basename($recent->room->RoomImage()) }}">
                        </a>
                        @foreach ($recent->room->RoomImages()->skip(1) as $key => $image)
                            <a href="{{ asset('storage/' . $image->file_path) }}"
                                data-fancybox="gallery_{{ $recent->room->id }}"
                                data-caption="{{ $recent->room->name }}">
                                <img class="me-3 rounded img-thumbnail"
                                    src="{{ asset('storage/' . $image->file_path) }}"
                                    alt="{{ basename($image->file_path) }}" style="display: none">
                            </a>
                        @endforeach
                        <div class="ms-4 bed-text">
                            <h4>{{ $recent->room->roomType->name . ' ' . $recent->room->name }}</h4>
                            <span><small>({{ 'From: ' . $recent->calculateDaysLengthFrom() . ' To: ' . $recent->calculateDaysLengthTo() }})</small></span>
                            <div class="users d-flex align-items-center">
                                <img src="images/users/user1.jpg" alt="">
                                <div>
                                    <span
                                        class="fs-16 font-w500 me-3">{{ Str::limit($recent->guest->full_name, 15) }}</span>
                                    <span>{{ $recent->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="date bg-sm bg-secondary mb-3">{{ $recent->calculateNight() }}</span>
                </div>
            @endforeach

        </div>
        <div class="card-footer border-0 m-auto pt-0">
            <a href="javascript:void(0);" class="btn btn-link m-auto dlab-load-more fs-16 font-w500 text-secondary"
               id="load-more-btn" style="{{ count($recent_room_reservations) < 1 ? 'display: none;' : '' }}">
                View more
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $(document).ready(function() {
            let currentPage = 1;

            $('#load-more-btn').click(function() {
                currentPage++;
                $.ajax({
                    url: "{{ route('dashboard.load-more-recent-reservation') }}",
                    type: "GET",
                    data: {
                        page: currentPage
                    },
                    success: function(response) {
                        $('.loadmore-content').append(response.html);
                        if (!response.hasMore) {
                            $('#load-more-btn').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading more posts:', error);
                    }
                });
            });
        });
    });
</script>
