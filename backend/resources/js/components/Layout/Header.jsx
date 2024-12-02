import React from 'react';
import { Link, useNavigate } from 'react-router-dom';

const Header = () => {
    const navigate = useNavigate();
    const [notifications, setNotifications] = React.useState(5); // Example notification count

    // Check if the user is authenticated
    const authToken = localStorage.getItem('authToken');
    const patientName = localStorage.getItem('userName');

    // Logout function
    const logout = () => {
        // Remove auth token and user info from localStorage
        localStorage.removeItem('authToken');
        localStorage.removeItem('userName');

        // Redirect to the login page after logout
        navigate('/login');
    };

    return (
        <nav className="navbar navbar-expand-lg navbar-light bg-light">
            <div className="container-fluid">
                <Link className="navbar-brand" to="/">Patient Portal</Link>
                <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>
                <div className="collapse navbar-collapse" id="navbarNav">
                    <ul className="navbar-nav ms-auto">
                        {authToken ? (
                            <>
                                <li className="nav-item">
                                    <span className="navbar-text mt-3">
                                        Welcome, {patientName}
                                    </span>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/notifications">
                                        <i className="bi bi-bell"></i>
                                        Notifications {notifications > 0 && <span className="badge bg-danger">{notifications}</span>}
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/appointments">Appointments</Link>
                                </li>
                                <li className="nav-item">
                                    <button className="nav-link btn" onClick={logout}>Logout</button>
                                </li>
                            </>
                        ) : (
                            <>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/login">Login</Link>
                                </li>
                                <li className="nav-item">
                                    <Link className="nav-link" to="/register">Register</Link>
                                </li>
                            </>
                        )}
                    </ul>
                </div>
            </div>
        </nav>
    );
};

export default Header;
