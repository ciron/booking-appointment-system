@extends('Layouts.Master')

@section('content')
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    @endpush
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
           <div class="col-md-8">
               <div class="card mb-4">
                   <div class="card-body">
                       <h4> Add new Slot of Doctor Availablity</h4>
                       <p>Note: Here we take time  8AM to 10Pm of a day</p>
                       <form method="post" action="{{ route('addNewSlot') }}">
                           @csrf
                           <div class="mb-3">
                               <label for="exampleSelect" class="form-label">Select Slot Date</label>
                               <input type="date" name="date" id="date" class="form-control" required>
                           </div>
                           <div class="mb-3">
                               <label for="exampleSelect" class="form-label">Select Slot</label>
                               <select class="form-select select2" name="slot[]"  required multiple id="slot_data">

                               </select>
                           </div>



                           <button type="submit" class="btn btn-primary">Submit</button>
                       </form>
                   </div>
               </div>
           </div>
        </div>
        <div class="row">

            <div id="calendar"></div>
        </div>

    </div>
</main>
    @push('js')
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.15/index.global.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>

            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
        <script>
            var  event_data =   @json($events);
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    height: 600,

                    initialView: 'dayGridMonth',
                    allDaySlot: false,
                    minTime: "08:00:00",
                    maxTime: "20:00:00",
                    slotDuration: "01:00:00",
                    events:event_data,
                    selectable: true, // Allow selection of slots
                    select: function(info) {
                        alert("Selected Slot: " + info.start.toISOString() + " to " + info.end.toISOString());
                    }
                });

                calendar.render();
            });
        </script>
        <script>

            $(document).ready(function() {
                $('#date').on('change', function() {

                    let date = $(this).val();
                    var url = "{{ route('AvailableForCreate') }}";
                    if (date) {
                        $.ajax({
                            url: url,
                            method: 'get',
                            data: {
                                date: date
                            },
                            success: function(response) {
                                $('#slot_data').html(response);
                            },
                            error: function(xhr, status, error) {

                            }
                        });
                    }


                });
            });
        </script>
    @endpush
@endsection
