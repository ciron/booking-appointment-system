import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { loginUser } from '../Util/api';  // Import API utility

const LoginPage = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState(null);
    const navigate = useNavigate();

    const handleLogin = async (e) => {
        e.preventDefault();
        const userData = { email, password };

        try {
            const response = await loginUser(userData);
            if (response.success) {
                localStorage.setItem('authToken', response.token);  // Save the token to localStorage or sessionStorage
                navigate('/authenticated-landing');  // Redirect to the authenticated landing page
            } else {
                setError(response.message);
            }
        } catch (error) {
            setError('Login failed');
        }
    };

    const handleRegisterRedirect = () => {
        navigate('/register');  // Redirect to the registration page
    };

    return (
        <div className="container mt-5">
            <h1 className="text-center">Login Patient</h1>
            <form onSubmit={handleLogin}>
                <div className="mb-3">
                    <label htmlFor="email" className="form-label">Email</label>
                    <input
                        type="email"
                        className="form-control"
                        id="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                    />
                </div>
                <div className="mb-3">
                    <label htmlFor="password" className="form-label">Password</label>
                    <input
                        type="password"
                        className="form-control"
                        id="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                    />
                </div>
                {error && <div className="alert alert-danger">{error}</div>}
                <button type="submit" className="btn btn-primary">Login</button>

            </form>
            <button className="btn btn-secondary" onClick={handleRegisterRedirect}>Register</button>
        </div>
    );
};

export default LoginPage;
