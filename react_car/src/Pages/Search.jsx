  import React from 'react';
  import { useEffect, useState } from "react";
  import Swal from "sweetalert2";
  import HeroPages from "../components/HeroPages";
  import { useNavigate } from "react-router-dom";

  function Search() {
    const [email, setEmail] = useState("");
    const [phoneNumber, setPhoneNumber] = useState("");
    const [error, setError] = useState(null);
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
      e.preventDefault();

      if (!email.trim()) {
        setError("Email is required.");
        return;
      } else if (!phoneNumber.trim()) {
        setError("Phone number is required.");
        return;
      }

      const searchData = new FormData();
      searchData.append('email', email);
      searchData.append('phone_number', phoneNumber);

      try {
        Swal.fire({
          title: "ກຳລັງສົ່ງຂໍ້ມູນ...",
          text: "ກະລຸນາຖ້າ",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          },
        });

        const response = await fetch("http://localhost:8000/api/searchData", {
          method: "POST",
          body: searchData,
          headers: {
            Accept: "application/json",
          },
        });

        if (!response.ok) {
          const errorText = await response.text();
          throw new Error(errorText);
        }

        const data = await response.json();

        Swal.close();

        if (data && Object.keys(data).length > 0) {
          navigate("/order", { state: { searchResults: data } });
          // console.log(data);
        } else {
            Swal.fire({
              icon: "warning",
              title: "ບໍ່ພົບຂໍ້ມູນ",
              text: "ບໍ່ມີຂໍ້ມູນທີ່ກົງກັບອີເມວແລະເບີໂທລະສັບທີ່ທ່ານປ້ອນ.",
              confirmButtonText: "ຕົກລົງ",
            });
        }


      } catch (error) {
        console.error("Error submitting form:", error);
        setError(error.message);

        Swal.fire({
          icon: "error",
          title: "ເກີດຄວາມຜິດພາດຂຶ້ນ.",
          text: "ບໍ່ມີຂໍ້ມູນທີ່ກົງກັບອີເມວແລະເບີໂທລະສັບທີ່ທ່ານປ້ອນ.",
          confirmButtonText: "ລອງອີກຄັ້ງ",
        });
      }
    };

    return (
      <>
        <HeroPages name="ຈັດການການຈອງ" />
        <div className="containersearch">
          <div className="image">
            <img
              className="img"
              src="https://t-cf.bstatic.com/design-assets/assets/v3.138.0/illustrations-traveller/TripsCarRentalManageMyAccount.png"
              alt=""
              srcset=""
            />
          </div>
          <div className="form">
            <form onSubmit={handleSubmit} className="form-container">
              <h2 className="form-title">Manage my booking</h2>
              <div className="form-group">
                <label>Email address *</label>
                <input
                  type="email"
                  name="email"
                  placeholder="Enter your email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                />
              </div>
              <div className="form-group">
                <label>Phone number *</label>
                <input
                  type="text"
                  name="phoneNumber"
                  placeholder="Enter your Phone number"
                  value={phoneNumber}
                  onChange={(e) => setPhoneNumber(e.target.value)}
                />
              </div>
              {error && <div className="error-message">{error}</div>}
              <button type="submit" className="find-booking-button">
                Find my booking
              </button>
            </form>
          </div>
        </div>
      </>
    );
  }

  export default Search;
