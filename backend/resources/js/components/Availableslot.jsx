import React, { useState, useEffect } from 'react';
import { useParams,useNavigate  } from 'react-router-dom';  // Use useParams to get the doctorId
import { Calendar, momentLocalizer } from 'react-big-calendar';
import moment from 'moment';
import 'react-big-calendar/lib/css/react-big-calendar.css';
import { fetchAvailableSlots } from '../Util/api'; // Import the API function

const localizer = momentLocalizer(moment);

const AvailableSlot = () => {
    const { doctorId } = useParams();  // Get the doctorId from the URL
    const [events, setEvents] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [doctorName, setDoctorName] = useState('');
    const navigate = useNavigate();
    // Fetch available slots from the API
    useEffect(() => {
        const loadAvailableSlots = async () => {
            try {
                const slotData = await fetchAvailableSlots(doctorId);
                setDoctorName(slotData.name);
                const formattedSlots = slotData.slots.map(slot => {
                    // Extract start and end times from 'name' field (e.g., '08:00 AM - 09:00 AM')
                    const [startTime, endTime] = slot.name.split(' - ');

                    // Combine the date with the start and end times to create Date objects
                    const startDate = new Date(`${slot.date} ${startTime}`);
                    const endDate = new Date(`${slot.date} ${endTime}`);

                    return {
                        id: slot.id,
                        title:  slot.name,
                        start: startDate,
                        end: endDate,
                    };
                });

                setEvents(formattedSlots);
            } catch (error) {
                setError(error.message);
            } finally {
                setLoading(false);
            }
        };

        loadAvailableSlots();
    }, [doctorId]);  // Re-fetch when doctorId changes

    if (loading) {
        return <div className="text-center mt-4">Loading available slots...</div>;
    }

    if (error) {
        return (
            <div className="container mt-4">
                <div className="alert alert-danger" role="alert">
                    {error}
                </div>
            </div>
        );
    }
    const currentDate = new Date();

    return (
        <div className="container mt-5">
            <h1 className="text-center">Available Slots for Doctor: {doctorName}</h1>
            <button
                className="btn btn-primary mb-4"
                onClick={() => navigate(-1)}  // Go back to the previous page
            >
                Back
            </button>
            <Calendar
                localizer={localizer}
                events={events}
                startAccessor="start"
                endAccessor="end"
                style={{ height: 500, margin: '50px' }}
                selectable
                defaultDate={currentDate}
                onSelectSlot={(slotInfo) => alert(`Slot selected: ${slotInfo.start}`)}
                onSelectEvent={(event) => alert(`Event clicked: ${event.title}`)}
                views={['month', 'week', 'day']}
            />
        </div>
    );
};

export default AvailableSlot;
