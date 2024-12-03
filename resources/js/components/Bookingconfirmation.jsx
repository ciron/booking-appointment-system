import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import PatientPanelLayout from './PatientPanelLayout';

const BookingConfirmation = () => {

    const { slotId } = useParams();

    return (
        <PatientPanelLayout >
        <div className="container mt-5">
            <h1 className="text-center">Booking Confirmation</h1>
            <p className="text-center">
                Your slot  has been booked successfully! For Details Please visit Appointments page.. Thanks
            </p>
        </div>
        </PatientPanelLayout>
    );
};

export default BookingConfirmation;
