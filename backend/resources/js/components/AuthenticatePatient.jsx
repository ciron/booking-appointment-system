import React, { useState, useEffect } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import { fetchDoctors } from "../Util/api"; // Import API utility

const AuthenticatePatient = () => {
    const [doctors, setDoctors] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const loadDoctors = async () => {
            try {
                const doctorData = await fetchDoctors(); // Call the function from api.js
                setDoctors(doctorData); // Update state with fetched data
            } catch (err) {
                setError(err.message || "Failed to load doctors");
            } finally {
                setLoading(false);
            }
        };

        loadDoctors();
    }, []);

    if (loading) {
        return <div className="text-center mt-4">Loading...</div>;
    }

    if (error) {
        return (
            <div className="container mt-4">
                <div className="alert alert-danger" role="alert">
                    {error}
                </div>
            </div>
        );
    }

    return (
        <div className="container mt-4">
            <h2 className="mb-4">Doctor List</h2>
            <div className="row">
                {doctors.length > 0 ? (
                    doctors.map((doctor) => (
                        <div className="col-md-4 mb-4" key={doctor.id}>
                            <div className="card">
                                <div className="card-body">
                                    <h5 className="card-title">{doctor.name}</h5>
                                    <h6 className="card-subtitle mb-2 text-muted">
                                        {doctor.specialization}
                                    </h6>
                                    <p className="card-text">Email: {doctor.email}</p>
                                    <a href={`/doctor/${doctor.id}`} className="btn btn-primary">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    ))
                ) : (
                    <p className="text-center">No doctors available.</p>
                )}
            </div>
        </div>
    );
};

export default AuthenticatePatient;
