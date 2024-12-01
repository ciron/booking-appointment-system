<?php


function AvailableSlot($created_slot){
    $slot_array =[
        '08:00 AM - 09:00 AM',
        '09:00 AM - 10:00 AM',
        '10:00 AM - 11:00 AM',
        '11:00 AM - 12:00 PM',
        '12:00 PM - 01:00 PM',
        '01:00 PM - 02:00 PM',
        '02:00 PM - 03:00 PM',
        '03:00 PM - 04:00 PM',
        '04:00 PM - 05:00 PM',
        '05:00 PM - 06:00 PM',
        '06:00 PM - 07:00 PM',
        '07:00 PM - 08:00 PM',
        '08:00 PM - 09:00 PM',
        '09:00 PM - 10:00 PM'
    ];


    $available_slots = array_diff($slot_array, $created_slot);

   return $available_slots;

}

function All_slots(){
    $allSlots = [
        '08:00 AM - 09:00 AM',
        '09:00 AM - 10:00 AM',
        '10:00 AM - 11:00 AM',
        '11:00 AM - 12:00 PM',
        '12:00 PM - 01:00 PM',
        '01:00 PM - 02:00 PM',
        '02:00 PM - 03:00 PM',
        '03:00 PM - 04:00 PM',
        '04:00 PM - 05:00 PM',
        '05:00 PM - 06:00 PM',
        '06:00 PM - 07:00 PM',
        '07:00 PM - 08:00 PM',
        '08:00 PM - 09:00 PM',
        '09:00 PM - 10:00 PM'
    ];

    return $allSlots;
}

function generateEvents($date, $allSlots, $availableMap)
{
    $events = [];

    // Check if the date has available slots in the map
    $availableSlots = $availableMap[$date] ?? [];

    foreach ($allSlots as $slot) {
        // Only process if the slot is available
        if (in_array($slot, $availableSlots)) {
            [$start, $end] = explode(' - ', $slot);

            $events[] = [
                'title' => 'Available',
                'start' => date('Y-m-d\TH:i:s', strtotime("$date $start")),
                'end' => date('Y-m-d\TH:i:s', strtotime("$date $end")),
                'color' => '#28a745', // Green for available slots
            ];
        }
    }

    return $events;
}


function successResponse($data = null, $message = '', $status = 200)
{
    return response()->json([
        'type' => 'success',
        'message' => $message,
        'data' => $data,
        'status' => $status,
    ], $status);
}

function failureResponse($message = '', $status = 400, $data = null)
{
    return response()->json([
        'type' => 'error',
        'message' => $message,
        'data' => $data,
        'status' => $status,
    ], $status);
}
