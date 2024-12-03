import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { fetchAppointments } from '../Util/api';// Import the fetchAppointments function
import PatientPanelLayout from "./Patientpanellayout"; // Import the ParentLayout component

const Appointments = () => {
    const [appointments, setAppointments] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const navigate = useNavigate();

    // Fetch appointments from API
    useEffect(() => {
        const fetchData = async () => {


            try {
                const data = await fetchAppointments();

                setAppointments(data);
            } catch (error) {
                setError(error.message);
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, [navigate]);

    if (loading) {
        return  <PatientPanelLayout> <div className="text-center mt-4">Loading appointments...</div></PatientPanelLayout>;
    }

    if (error) {
        return  <PatientPanelLayout><div className="alert alert-danger mt-4">{error}</div></PatientPanelLayout>;
    }

    return (
        <PatientPanelLayout>
            <div className="container mt-5">
                <h1 className="text-center mb-4">Your Appointments</h1>

                <table className="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    {appointments.length === 0 ? (
                        <tr>
                            <td colSpan="4" className="text-center">No appointments found.</td>
                        </tr>
                    ) : (
                        appointments.map((appointment) => (
                            <tr key={appointment.id}>
                                <td>{appointment.doctor.name}</td>
                                <td>{new Date(appointment.appointment_date).toLocaleDateString()}</td>
                                <td>{appointment.timeslot}</td>
                                <td>{appointment.status}</td>
                            </tr>
                        ))
                    )}
                    </tbody>
                </table>
            </div>
        </PatientPanelLayout>
    );
};

export default Appointments;
