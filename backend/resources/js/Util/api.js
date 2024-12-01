const BASE_URL = 'http://127.0.0.1:8000/api';  // Your backend API base URL

export const registerUser = async (userData) => {
    try {
        const response = await fetch(`${BASE_URL}/patient/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(userData),
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error registering user:', error);
        throw new Error('Registration failed');
    }
};

export const loginUser = async (userData) => {
    try {
        const response = await fetch(`${BASE_URL}/patient/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(userData),
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error logging in:', error);
        throw new Error('Login failed');
    }
};
