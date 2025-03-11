
import React, { useEffect, useState } from "react";
import { useLocation, useNavigate } from 'react-router-dom';
import '../styles/BookingSummary/BookingSummary.css'; 
import { Link } from 'react-router-dom';
import HeroPages from "../components/HeroPages";
import axios from 'axios';

function BookingSummary() {
  const location = useLocation();
    const [userList, setUserList] = useState([]);
   const [error, setError] = useState(null);
  const navigate = useNavigate();
  const {
    car,
    pickUpandDropoff,
    pickTime,
    dropTime,
    startTime,
    endTime,
    days,
    total,
    formData,
  } = location.state || {};
  // useEffect(() => {
  //   const fetchUser = async () => {
  //     try {
  //       const response = await axios.get("http://localhost:8000/api/users/show");
  //       if (Array.isArray(response.data.data)) {
  //         setUserList(response.data.data);
  //       } else {
  //         throw new Error("Invalid data format received from the server");
  //       }
  //     } catch (err) {
  //       setError(err.message);
  //     }
  //   };
  
  //   fetchUser();
  // }, []);
  // console.log(userList)
  
  
  const handleConfirmBooking = () => {
    navigate('/bookingconfirmation');
  };
    const editinfo = () => {
        navigate('/Editinfo',{state:{
          formData
        }
        })

    };
    console.log(formData)

  return (
    <>
    <HeroPages name="ລາຍລະອຽດ"/>
    <div className="booking-summary">
      <h1 className="title">Booking Summary</h1>

      <div className="section car-details">
        <h2>Car Details</h2>
        <div className="car-info">
          <img className="car-image" src={car?.images} alt={car?.car_name} />
          <div className="car-text">
            <p><strong>Car Name:</strong> {car?.car_name}</p>
            <p><strong>Car Type:</strong> {car?.car_type_name}</p>
            <p><strong>Price per Day:</strong> {car?.price_daily} KIP</p>
            <p><strong>Total Price:</strong> {total} KIP</p>
          </div>
        </div>
      </div>

      <div className="section booking-dates">
        <h2>Booking Dates & Times</h2>
        <p><strong>Pickup and Drop-off Location:</strong> {pickUpandDropoff}</p>
        <p><strong>Pickup Time:</strong> {pickTime}</p>
        <p><strong>Drop-off Time:</strong> {dropTime}</p>
        <p><strong>Rental Start Time:</strong> {startTime}</p>
        <p><strong>Rental End Time:</strong> {endTime}</p>
        <p><strong>Total Days:</strong> {days}</p>
      </div>

      <div className="section personal-info">
        <h2>Your Personal Information</h2>
        <p><strong>First Name:</strong> {formData.first_name}</p>
        <p><strong>Last Name:</strong> {formData.last_name}</p>
        <p><strong>Phone Number:</strong> {formData.phone_number}</p>
        <p><strong>Email:</strong> {formData.email}</p>
        <p><strong>Address:</strong> {formData.address}</p>
        <p><strong>Village:</strong> {formData.village}</p>
        <p><strong>City:</strong> {formData.city}</p>
        <p><strong>Province:</strong> {formData.province}</p>
        <p><strong>Zip Code:</strong> {formData.zipcode}</p>
      </div>

      {formData.image && (
        <div className="uploaded-image">
          <h3>Uploaded Image</h3>
          <img src={formData.image} alt="Uploaded Image" />
        </div>
      )}

      <button className="confirm-button" onClick={editinfo}>editinfo</button>
      <button className="confirm-button" onClick={handleConfirmBooking}>
        Confirm Booking
      </button>
    </div>
    </>
  );
}

export default BookingSummary;
