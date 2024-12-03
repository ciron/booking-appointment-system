import React, { useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import { BrowserRouter as Router, Routes, Route, useNavigate, useLocation } from 'react-router-dom'; // Added useLocation
import LoginPage from './components/LoginPage';
import RegistrationPage from './components/RegistrationPage';
import AuthenticatePatient from './components/AuthenticatePatient';
import Availableslot from './components/Availableslot';
import BookingConfirmation from './components/Bookingconfirmation';
import Appointments from './components/Appointment';

const App = () => {
    const navigate = useNavigate();
    const location = useLocation();

    useEffect(() => {
        const authToken = localStorage.getItem('authToken');
        const isAuthenticated = Boolean(authToken);

        if (!isAuthenticated) {

            if (location?.pathname !== '/login' && location?.pathname !== '/register') {
                navigate('/login');
            }
        } else {

            if (['/login', '/'].includes(location?.pathname)) {
                navigate('/authenticate-patient');
            }
        }
    }, [navigate, location]);

    return (
        <Routes>
            <Route path="/login" element={<LoginPage />} />
            <Route path="/register" element={<RegistrationPage />} />
            <Route path="/authenticate-patient" element={<AuthenticatePatient />} />
            <Route path="/available-slot/:doctorId" element={<Availableslot />} />
            <Route path="/booking-confirmation/:slotId" element={<BookingConfirmation />} />
            <Route path="/appointments" element={<Appointments />} />
        </Routes>
    );
};

const root = ReactDOM.createRoot(document.getElementById('app')); // Define root element

root.render(
    <Router>
        <App />
    </Router>
);
