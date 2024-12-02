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
export const fetchDoctors = async () => {
    try {
        const token = localStorage.getItem('authToken'); // Retrieve the token from local storage

        const response = await fetch(`${BASE_URL}/patient/doctor-list`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
        });

        const result = await response.json(); // Parse the response

        if (response.ok && result.type === 'success') {
            return result.data; // Return the doctor list
        } else {
            throw new Error(result.message || "Failed to fetch doctor list");
        }
    } catch (error) {
        console.error("Error in API call:", error);
        throw error;
    }
};


export const fetchAvailableSlots = async (doctorId) => {
    try {
        const token = localStorage.getItem('authToken'); // Retrieve the token from local storage
        const response = await fetch(`${BASE_URL}/patient/doctor-slot-list/${doctorId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
        });
        const result = await response.json();
        if (response.ok && result.type === 'success') {
            return result.data; // Return the doctor list
        } else {
            throw new Error(result.message || "Failed to fetch doctor list");
        }


    } catch (error) {
        console.error('Error in API call:', error);
        throw error; // Re-throw the error to be handled by the calling code
    }
};
