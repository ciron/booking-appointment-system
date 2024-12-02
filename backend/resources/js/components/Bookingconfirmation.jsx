import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import PatientPanelLayout from './PatientPanelLayout';

const BookingConfirmation = () => {
    const [patientName] = useState('John Doe');
    const { slotId } = useParams();

    return (
        <PatientPanelLayout patientName={patientName}>
        <div className="container mt-5">
            <h1 className="text-center">Booking Confirmation</h1>
            <p className="text-center">
                Your slot with ID {slotId} has been booked successfully!
            </p>
        </div>
        </PatientPanelLayout>
    );
};

export default BookingConfirmation;
