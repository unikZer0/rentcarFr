import React, { useEffect, useState } from "react";
import axios from "axios";
import { useLocation, useNavigate } from "react-router-dom";
import BookCar from "../components/BookCar";
import HeroPages from "../components/HeroPages";
import Swal from "sweetalert2";
import "../dist/styles.css";

function Booking_begin() {
  const navigate = useNavigate();
  const location = useLocation();

  const [pickUpandDropoff, setPickUpandDropoff] = useState("");
  const [pickTime, setPickTime] = useState("");
  const [dropTime, setDropTime] = useState("");
  const [carList, setCarList] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const {
    pickUpandDropoff: initialPickUpandDropoff,
    pickTime: initialPickTime,
    dropTime: initialDropTime,
    startTime,
    endTime,
  } = location.state || {};

  useEffect(() => {
    if (initialPickUpandDropoff) setPickUpandDropoff(initialPickUpandDropoff);
    if (initialPickTime) setPickTime(initialPickTime);
    if (initialDropTime) setDropTime(initialDropTime);

    const fetchCars = async () => {
      try {
        const response = await axios.get("http://localhost:8000/api/cars", {
          params: { start: initialPickTime, end: initialDropTime },
        });
        if (Array.isArray(response.data.data)) {
          setCarList(response.data.data);
        } else {
          throw new Error("Invalid data format received from the server");
        }
      } catch (err) {
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };

    fetchCars();
  }, [initialPickUpandDropoff, initialPickTime, initialDropTime]);

  const calculateDaysAndTotal = (pickTime, dropTime, dailyRate) => {
    if (!pickTime || !dropTime || isNaN(dailyRate)) {
      return { days: 0, total: 0 };
    }

    const startDate = new Date(pickTime);
    const endDate = new Date(dropTime);

    if (
      isNaN(startDate.getTime()) ||
      isNaN(endDate.getTime()) ||
      startDate >= endDate
    ) {
      return { days: 0, total: 0 };
    }

    const timeDifference = endDate - startDate;
    const daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));
    const totalCost = daysDifference * dailyRate;

    return { days: daysDifference, total: totalCost };
  };

  const openrent = (e, car, index) => {
    e.preventDefault();
    if (pickUpandDropoff === "" || pickTime === "" || dropTime === "") {
      Swal.fire({
        icon: "error",
        title: "ກະລຸນາປ້ອນທຸກຂໍ້ມູນ",
        text: "All fields are required!",
      });
    } else {
      const { days, total } = calculateDaysAndTotal(
        pickTime,
        dropTime,
        car.price_daily
      );
      if (isNaN(days) || isNaN(total) || days === 0 || total === 0) {
        Swal.fire({
          icon: "error",
          title: "ກະລຸນາກວດສອບວັນທີຕ້ອງ1ມື້ຂື້ນ",
          text: "Invalid date or price calculation!",
        });
      } else {
        navigate("/from", {
          state: {
            pickUpandDropoff,
            pickTime,
            dropTime,
            startTime,
            endTime,
            days,
            total,
            index,
          },
        });
      }
    }
  };

  useEffect(() => {
    if (loading) {
      Swal.fire({
        title: "ກຳລັງໂຫລດ...",
        text: "ກຳລັງດຶງຂໍ້ມູນ...",
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });
    } else {
      Swal.close();
    }
  }, [loading]);

  useEffect(() => {
    if (error) {
      Swal.fire({
        icon: "error",
        title: "ມີຂໍ້ຜິດພາດ",
        text: error,
        confirmButtonText: "ລອງໃຫມ່",
      }).then(() => {
        window.location.reload();
      });
    }
  }, [error]);

  if (loading || error) {
    return null;
  }

  return (
    <>
      <HeroPages name="ຄົ້ນຫາ" />
      <BookCar />
      <div className="booking">
        <h1>ຜົນການຄົ້ນຫາ: ລົດທີ່ມີທັງຫມົດ</h1>
        <div className="booking__cards">
          {carList.map((car, index) => {
            const { days, total } = calculateDaysAndTotal(
              pickTime,
              dropTime,
              car.price_daily
            );
            return (
              <div className="car-card" key={index}>
                {/* <p>{car.car_id}</p> */}
                <img
                  src={`http://localhost:8000/${car.image}`}
                  alt={car.car_name}
                  className="car-card__image"
                />
                <div className="car-card__content">
                  <h3 className="car-card__title">{car.car_name}</h3>
                  <h2 className="car-card__description">{car.descriptions}</h2>
                  <h2 className="car-card__user_name">ໂດຍ: {car.user.name}</h2>
                  <h2 className="car-card__description">
                    ປະເພດ: {car.car_type.car_type_name}
                  </h2>
                  <div className="stroke">
                    <h1
                      className={`car-card__status status-${car.car_status.toLowerCase()}`}
                    >
                      ສະຖານະ: {car.car_status}
                    </h1>
                  </div>
                  <div className="car-card__price">
                    <h4 className="car-card__price-amount">
                      {car.price_daily} ₭/ວັນ
                    </h4>
                    <p className="car-card__price-total">
                      {isNaN(total)
                        ? "ບໍ່ສາມາດຄິດໄລ່ລາຄາໄດ້"
                        : `ລວມ ${days} ວັນ  ${total} ₭`}
                    </p>
                  </div>
                  <div className="car-card-bnt">
                    <button
                      onClick={(e) => openrent(e, car, car.car_id)}
                      className="car-card-bnt__button"
                      disabled={car.car_status !== "Available"}
                    >
                      ເຊົ່າລົດ
                    </button>
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </>
  );
}

export default Booking_begin;
