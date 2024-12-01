import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { registerUser } from '../Util/api';  // API call for registration

const RegistrationPage = () => {
    const [name, setUsername] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState(null);
    const navigate = useNavigate();

    const handleRegister = async (e) => {
        e.preventDefault();
        const userData = { name, email, password };

        try {
            const response = await registerUser(userData);
            if (response.type === 'success') {

                if (response.data && response.data.token) {

                    localStorage.setItem('authToken', response.data.token);

                    navigate('/authenticate-patient');
                } else {

                    setError('Something went wrong. No token received.');
                }
            } else {
                setError(response.message);  // Display error message if the response type is not success
            }
        } catch (error) {
            setError('Registration failed');
        }
    };

    return (
        <div className="container mt-5">
            <h1 className="text-center">RegistaSer</h1>
            <form onSubmit={handleRegister}>
                <div className="mb-3">
                    <label htmlFor="name" className="form-label">Name</label>
                    <input
                        type="text"
                        className="form-control"
                        id="name"
                        value={name}
                        onChange={(e) => setUsername(e.target.value)}
                    />
                </div>
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
                <button type="submit" className="btn btn-primary">Register</button>
            </form>
        </div>
    );
};

export default RegistrationPage;
