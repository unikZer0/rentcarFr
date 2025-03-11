import React from "react";
import { useLocation } from "react-router-dom";
import { useNavigate } from "react-router-dom";
import HeroPages from "../components/HeroPages";
import Swal from "sweetalert2";
import "../dist/styles.css";
import "../styles/BookingSummary/BookingSummary.css";
function OrderCUM() {
  const navigate = useNavigate(); 
  const location = useLocation();
  const searchResults = location.state?.searchResults || {};

  const customerData = Array.isArray(searchResults.customer)
    ? searchResults.customer
    : searchResults.customer
    ? [searchResults.customer]
    : [];

  const bookingsData = Array.isArray(searchResults.bookings)
    ? searchResults.bookings
    : searchResults.bookings
    ? [searchResults.bookings]
    : [];
  const carsData = Array.isArray(searchResults.car)
    ? searchResults.car
    : searchResults.car
    ? [searchResults.car]
    : [];

  const ordersData = Array.isArray(searchResults.orders)
    ? searchResults.orders
    : searchResults.orders
    ? [searchResults.orders]
    : [];

    const handleDeleteCustomer = async (customerId) => {
      const result = await Swal.fire({
        title: "ຕ້ອງການລຶບລູກຄ້າຄົນນີ້ແທ້ບໍ່?",
        text: "ການກະທຳນີ້ບໍ່ສາມາດຍົກເລີກໄດ້!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ຕົກລົງ, ລຶບ!",
        cancelButtonText: "ຍົກເລີກ",
      });
      if (result.isConfirmed) {
        try {
          const response = await fetch(`http://localhost:8000/api/searchData/${customerId}`, {
            method: "DELETE",
            headers: {
              "Accept": "application/json",
              "Content-Type": "application/json",
            },
          });
    
          const data = await response.json();
          if (response.ok) {
            Swal.fire("ລຶບແລ້ວ!", "ລູກຄ້າຖືກລຶບສຳເລັດ.", "success");
            navigate("/"); 
          } else {
            Swal.fire("ເກີດຂໍ້ຜິດພາດ!", data.message || "ບໍ່ສາມາດລຶບລູກຄ້າໄດ້.", "error");
          }
        } catch (error) {
          Swal.fire("ເກີດຂໍ້ຜິດພາດ!", "ມີບັນຫາໃນການລຶບຂໍ້ມູນ.", "error");
        }
      }
    };
    

  return (
    <>
      <HeroPages name="ຈັດການການຈອງ" />
      <div className="booking-summary">
        {carsData.map((cars, index) => (
          <div key={index} className="section booking-dates">
            <h2>Car Details</h2>
            <div className="car-info">
              <img
                className="car-image"
                src={`http://localhost:8000/${cars.image}`}
                alt="Car"
              />
              <div className="car-text">
                <p>
                  <strong>Car Name:</strong> {cars.car_name}
                </p>
                <p>
                  <strong>Price per Day:</strong> {cars.price_daily} KIP
                </p>
              </div>
            </div>
          </div>
        ))}
        {bookingsData.map((booking, book) => (
          <div key={book} className="section booking-dates">
            <h2>Booking Dates & Times</h2>
            <p>
              <strong>Pickup and Drop-off Location:</strong> {booking.Location}
            </p>
            <p>
              <strong>Pickup Time:</strong> {booking.Pickup}
            </p>
            <p>
              <strong>Drop-off Time:</strong> {booking.dropoof}
            </p>
            <p>
              <strong>Rental Start Time:</strong> {booking.start}
            </p>
            <p>
              <strong>Rental End Time:</strong> {booking.end}
            </p>
          </div>
        ))}
              {ordersData.map((order, ordersData) => (
          <div key={ordersData} className="section booking-dates">
            <h2>Order</h2>
            <p>
              <strong>Total Days:</strong> {order.days}
            </p>
            <p>
              <strong>Total Price:</strong> {order.total}
            </p>
          </div>
        ))}
        {customerData.map((customer, cus) => (
          <div key={cus} className="section personal-info">
            <h2>Your Personal Information</h2>
            <p>
              <strong>First Name:</strong> {customer.first_name}
            </p>
            <p>
              <strong>Last Name:</strong> {customer.last_name}
            </p>
            <p>
              <strong>Age:</strong> {customer.age}
            </p>
            <p>
              <strong>Phone Number:</strong> {customer.phone_number}
            </p>
            <p>
              <strong>Email:</strong> {customer.email}
            </p>
            <p>
              <strong>Address:</strong> {customer.address}
            </p>

            <p>
              <strong>City:</strong> {customer.city}
            </p>
            <p>
              <strong>Country:</strong> {customer.country}
            </p>
            <p>
              <strong>Zip Code:</strong> {customer.zipcode}
            </p>
          </div>
        ))}
         {customerData.map((customer, cus) => (
          <div key={cus} className="delete">
            <button
              className="confirm-button"
              onClick={() => handleDeleteCustomer(customer.cus_id)}
            >
              ລຶບ
            </button>
          </div>
        ))}
        
      </div>
    </>
  );
}

export default OrderCUM;
