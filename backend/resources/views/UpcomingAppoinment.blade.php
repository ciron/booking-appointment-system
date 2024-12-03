@extends('Layouts.Master')

@section('content')
    @push('css')

    @endpush
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Upcoming Appointment</li>
        </ol>

        <div class="row">

            <div class="card-body">
                <table id="datatablesSimple" class="table-responsive table ">
                    <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>

                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->name }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->timeslot }}</td>
                        <td>{{ $appointment->status }}</td>
                        <td>
                        @if($appointment->status == 'Pending')
                            <!-- Button to confirm appointment -->
                                <form action="{{ route('confirmAppointment', $appointment->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">Confirm</button>
                                </form>
                                <!-- Button to cancel appointment -->
                                <form action="{{ route('cancelAppointment', $appointment->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                </form>
                        @elseif($appointment->status == 'Confirmed')
                            <!-- Button to cancel appointment -->
                                <form action="{{ route('cancelAppointment', $appointment->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
    @push('js')

    @endpush
@endsection
