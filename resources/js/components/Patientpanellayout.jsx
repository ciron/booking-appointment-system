import React from 'react';
import Header from './Layout/Header';
import Footer from './Layout/Footer';


const PatientPanelLayout = ({ patientName, children }) => {
    return (
        <div>
            <Header patientName={patientName} />
            <main className="container mt-4" style={{ minHeight: 'calc(100vh - 100px)' }}>
                {children}
            </main>
            <Footer />
        </div>
    );
};

export default PatientPanelLayout;
