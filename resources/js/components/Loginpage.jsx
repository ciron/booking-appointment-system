import React, { useState } from 'react';
import { Link,useNavigate } from 'react-router-dom';
import { loginUser } from '../Util/api';

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
            console.log(response);
            if (response.type === 'success') {
                if (response.data && response.data.token) {
                    localStorage.setItem('userName', response.data.name);
                    localStorage.setItem('authToken', response.data.token);

                    navigate('/authenticate-patient');
                } else {

                    setError('Something went wrong. No token received.');
                }
            } else {
                setError(response.message);
            }
        } catch (error) {
            setError('Login failed');
        }
    };

    return (
        <div className="container mt-5" style={{ maxWidth: '600px' }}>
            <h1 className="text-center">Login Patient</h1>
            <form onSubmit={handleLogin} >
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
                <div className="d-flex justify-content-between">
                <button type="submit" className="btn btn-primary">Login</button>
                    <p>If you dont have Account ?</p>
                    <Link to="/register" className="btn btn-secondary">
                        Register
                    </Link>
                </div>
            </form>

        </div>
    );
};

export default LoginPage;
