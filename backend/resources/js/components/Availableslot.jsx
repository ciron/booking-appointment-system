import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Calendar, momentLocalizer } from 'react-big-calendar';
import moment from 'moment';
import 'react-big-calendar/lib/css/react-big-calendar.css';
import { fetchAvailableSlots, bookSlot } from '../Util/api';
import PatientPanelLayout from "./Patientpanellayout";

const localizer = momentLocalizer(moment);

const AvailableSlot = () => {
    const { doctorId } = useParams();
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
                setDoctorName(slotData.name);
                const formattedSlots = slotData.slots.map(slot => {
                    const [startTime, endTime] = slot.name.split(' - ');
                    const startDate = new Date(`${slot.date} ${startTime}`);
                    const endDate = new Date(`${slot.date} ${endTime}`);

                    return {
                        id: slot.id,
                        title: slot.name,
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
    }, [doctorId]);

    // Handle event click
    const handleEventClick = async (event) => {
        const confirmBooking = window.confirm(
            `Are you sure you want to book this slot: ${event.title}?`
        );

        if (confirmBooking) {
            try {
                // Call booking API
                await bookSlot(event.id,doctorId);
                alert('Slot booked successfully! Redirecting to confirmation page...');
                navigate(`/booking-confirmation/${event.id}`); // Redirect to confirmation page
            } catch (error) {
                alert(`Booking failed: ${error.message}`);
            }
        }
    };

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
        <PatientPanelLayout>
        <div className="container mt-5">
            <h1 className="text-center">Available Slots for Doctor: {doctorName}</h1>
            <button
                className="btn btn-primary mb-4"
                onClick={() => navigate(-1)}
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
                onSelectEvent={handleEventClick} // Handle event clicks
                views={['month', 'week', 'day']}
            />
        </div>
        </PatientPanelLayout>
    );
};

export default AvailableSlot;
