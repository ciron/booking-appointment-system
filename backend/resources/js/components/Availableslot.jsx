

import React, { useState, useEffect } from 'react';
import { Calendar, momentLocalizer } from 'react-big-calendar';
import moment from 'moment';
import 'react-big-calendar/lib/css/react-big-calendar.css';

const localizer = momentLocalizer(moment);

const AuthenticatePatient = () => {
    const [events, setEvents] = useState([]);

    // Mock API data for available slots
    useEffect(() => {
        const fetchAvailableSlots = async () => {
            // Replace this with an actual API call
            const response = [
                {
                    id: 1,
                    title: 'Available Slot',
                    start: new Date(2024, 11, 4, 9, 0), // Dec 4, 2024, 9:00 AM
                    end: new Date(2024, 11, 4, 10, 0), // Dec 4, 2024, 10:00 AM
                },
                {
                    id: 2,
                    title: 'Available Slot',
                    start: new Date(2024, 11, 4, 11, 0), // Dec 4, 2024, 11:00 AM
                    end: new Date(2024, 11, 4, 12, 0), // Dec 4, 2024, 12:00 PM
                },
                {
                    id: 3,
                    title: 'Available Slot',
                    start: new Date(2024, 11, 5, 14, 0), // Dec 5, 2024, 2:00 PM
                    end: new Date(2024, 11, 5, 15, 0), // Dec 5, 2024, 3:00 PM
                },
            ];
            setEvents(response);
        };

        fetchAvailableSlots();
    }, []);

    const handleSlotClick = (slotInfo) => {
        alert(`Slot selected: ${slotInfo.start}`);
        // Additional functionality such as booking can be added here
    };

    return (
        <div className="container mt-5">
            <h1 className="text-center">Available Slots</h1>
            <Calendar
                localizer={localizer}
                events={events}
                startAccessor="start"
                endAccessor="end"
                style={{ height: 500, margin: '50px' }}
                selectable
                onSelectSlot={(slotInfo) => handleSlotClick(slotInfo)}
                onSelectEvent={(event) => alert(`Event clicked: ${event.title}`)}
                views={['month', 'week', 'day']}
            />
        </div>
    );
};

export default AuthenticatePatient;
