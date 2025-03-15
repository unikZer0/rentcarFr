import React, { useEffect, useState } from "react";
import axios from "axios";
import { useLocation, useNavigate } from "react-router-dom";
import BookCar from "../components/BookCar";
import HeroPages from "../components/HeroPages";
import Swal from "sweetalert2";
import { FaCar, FaGasPump, FaUsers, FaCog } from 'react-icons/fa';
import { motion } from 'framer-motion';
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
          throw new Error("ຮູບແບບຂໍ້ມູນທີ່ໄດ້ຮັບຈາກເຊີບເວີບໍ່ຖືກຕ້ອງ");
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
        text: "ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບທຸກຊ່ອງ!",
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
          text: "ວັນທີບໍ່ຖືກຕ້ອງ ຫຼື ການຄິດໄລ່ລາຄາບໍ່ຖືກຕ້ອງ!",
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
      <div className="container mx-auto px-4 py-16">
        <motion.h1 
          initial={{ opacity: 0, y: -20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="text-5xl font-extrabold text-center mb-16 text-gray-800"
        >
          ຜົນການຄົ້ນຫາ: <span className="text-orange-500">ລົດທີ່ມີທັງຫມົດ</span>
        </motion.h1>
        
        {carList.length === 0 ? (
          <div className="text-center py-10">
            <p className="text-xl text-gray-600">ບໍ່ພົບລົດທີ່ຄົ້ນຫາ</p>
          </div>
        ) : (
          <motion.div 
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.8, delay: 0.3 }}
            className="flex flex-wrap gap-16"
          >
            {carList.map((car, index) => {
              const { days, total } = calculateDaysAndTotal(
                pickTime,
                dropTime,
                car.price_daily
              );
              return (
                <motion.div
                  key={index}
                  whileHover={{ scale: 1.02 }}
                  className="car-card bg-white rounded-3xl overflow-hidden border border-gray-100"
                >
                  <div className="relative">
                    <img
                      src={`http://localhost:8000/${car.image}`}
                      alt={car.car_name}
                      className="w-full h-[400px] object-cover"
                    />
                    <div className="absolute top-6 right-6">
                      <span 
                        className={`status-badge ${
                          car.car_status === "Available" ? "status-available" : "status-unavailable"
                        }`}
                      >
                        {car.car_status === "Available" ? "ມີພ້ອມ" : "ບໍ່ມີພ້ອມ"}
                      </span>
                    </div>
                  </div>
                  
                  <div className="p-8">
                    <div className="flex justify-between items-center mb-6">
                      <h2 className="text-3xl font-bold text-gray-800">{car.car_name || "ບໍ່ມີຊື່"}</h2>
                      <p className="text-3xl font-bold text-orange-500">{car.price_daily} ₭/ວັນ</p>
                    </div>
                    
                    <p className="text-xl text-gray-600 mb-8">{car.descriptions}</p>
                    
                    <div className="grid grid-cols-2 gap-6 mb-8">
                      <div className="flex items-center gap-3 text-lg">
                        <FaUsers className="text-orange-500 text-2xl" />
                        <span>ໂດຍ: {car.user?.name || "ບໍ່ມີຂໍ້ມູນ"}</span>
                      </div>
                      <div className="flex items-center gap-3 text-lg">
                        <FaCar className="text-orange-500 text-2xl" />
                        <span>ປະເພດ: {car.car_type?.car_type_name || "ບໍ່ມີຂໍ້ມູນ"}</span>
                      </div>
                    </div>
                    
                    <div className="mb-8">
                      <p className="text-xl text-gray-700 font-semibold">
                        {isNaN(total)
                          ? "ບໍ່ສາມາດຄິດໄລ່ລາຄາໄດ້"
                          : `ລວມ ${days} ວັນ: ${total} ₭`}
                      </p>
                    </div>
                    
                    <button
                      onClick={(e) => openrent(e, car, car.car_id)}
                      className={`w-full py-4 text-xl font-bold rounded-xl transition-all ${
                        car.car_status === "Available"
                          ? "bg-orange-500 text-white hover:bg-orange-600 active:bg-orange-700"
                          : "bg-gray-300 text-gray-500 cursor-not-allowed"
                      }`}
                      disabled={car.car_status !== "Available"}
                    >
                      ເຊົ່າລົດ
                    </button>
                  </div>
                </motion.div>
              );
            })}
          </motion.div>
        )}
      </div>
    </>
  );
}

export default Booking_begin;
