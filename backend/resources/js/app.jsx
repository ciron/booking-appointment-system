import React, { useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import { BrowserRouter as Router, Routes, Route, useNavigate, useLocation } from 'react-router-dom'; // Added useLocation
import LoginPage from './components/LoginPage';
import RegistrationPage from './components/RegistrationPage';
import AuthenticatePatient from './components/AuthenticatePatient';
import Availableslot from './components/Availableslot';

const App = () => {
    const navigate = useNavigate();
    const location = useLocation();  // Get the current route location

    useEffect(() => {
        const isAuthenticated = localStorage.getItem('authToken');  // Check for token or session

        // Only redirect if the user is not authenticated and is not already on login or register pages
        if (!isAuthenticated && location.pathname !== '/login' && location.pathname !== '/register') {
            navigate('/login');  // Redirect to login page if not logged in
        } else if (isAuthenticated && location.pathname === '/login') {
            navigate('/authenticate-patient');  // Redirect to authenticated patient page if logged in and on login page
        }
    }, [navigate, location]);

    return (
        <Routes>
            <Route path="/login" element={<LoginPage />} />
            <Route path="/register" element={<RegistrationPage />} />
            <Route path="/authenticate-patient" element={<AuthenticatePatient />} />
            <Route path="/available-slot/:doctorId" element={<Availableslot />} />
        </Routes>
    );
};

const root = ReactDOM.createRoot(document.getElementById('app')); // Define root element

root.render(
    <Router>
        <App />
    </Router>
);
