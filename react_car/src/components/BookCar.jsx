import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { motion } from "framer-motion";
import { FaCalendarAlt, FaClock, FaMapMarkerAlt } from "react-icons/fa";

function BookCar() {
  const navigate = useNavigate();

  // State for form
  const [pickUpandDropoff, setpickUpandDropoff] = useState("");
  const [pickTime, setPickTime] = useState("");
  const [dropTime, setDropTime] = useState("");
  const [startTime, setStartTime] = useState("00:00");
  const [endTime, setEndTime] = useState("00:00");

  // Form change handlers
  const handlePickandDropo = (e) => {
    setpickUpandDropoff(e.target.value);
    localStorage.setItem("pickUpandDropoff", e.target.value);
  };

  const handlePickTime = (e) => {
    const selectedDate = e.target.value;
    setPickTime(selectedDate);
    localStorage.setItem("pickTime", selectedDate);
    const dropTimeInput = document.getElementById("droptime");
    dropTimeInput.setAttribute("min", selectedDate);
  };

  const handleDropTime = (e) => {
    const selectedDate = e.target.value;
    setDropTime(selectedDate);
    localStorage.setItem("dropTime", selectedDate);
  };

  const handleStartTimeChange = (e) => {
    const time = e.target.value;
    setStartTime(time);
    localStorage.setItem("startTime", time);
  };

  const handleEndTimeChange = (e) => {
    const time = e.target.value;
    setEndTime(time);
    localStorage.setItem("endTime", time); 
  };

  useEffect(() => {
    const storedPickUpandDropoff = localStorage.getItem("pickUpandDropoff");
    const storedPickTime = localStorage.getItem("pickTime");
    const storedDropTime = localStorage.getItem("dropTime");
    const storedStartTime = localStorage.getItem("startTime");
    const storedEndTime = localStorage.getItem("endTime");

    if (storedPickUpandDropoff) setpickUpandDropoff(storedPickUpandDropoff);
    if (storedPickTime) setPickTime(storedPickTime);
    if (storedDropTime) setDropTime(storedDropTime);
    if (storedStartTime) setStartTime(storedStartTime);
    if (storedEndTime) setEndTime(storedEndTime);
    const today = new Date();
    const thaiDateFormatter = new Intl.DateTimeFormat('en-CA', { 
      timeZone: 'Asia/Bangkok',
      year: 'numeric',
      month: '2-digit',
      day: '2-digit',
    });
    const minDate = thaiDateFormatter.format(today);
    const pickTimeInput = document.getElementById("picktime");
    const dropTimeInput = document.getElementById("droptime");

    if (pickTimeInput) pickTimeInput.setAttribute("min", minDate);
    if (dropTimeInput) dropTimeInput.setAttribute("min", minDate);
  }, []);

  const opensearch = (e) => {
    e.preventDefault();
    if (pickUpandDropoff === "" || pickTime === "" || dropTime === "" ) {
      alert("All fields are required!");
    } else {
      navigate("/booking", {
        state: {
          pickUpandDropoff,
          pickTime,
          dropTime,
          startTime,
          endTime,
        },
      });
    }
  };
  
  const generateTimes = () => {
    const timesArray = [];
    for (let hour = 0; hour < 24; hour++) {
      for (let minute = 0; minute < 60; minute += 30) {
        const formattedTime = `${String(hour).padStart(2, "0")}:${String(
          minute
        ).padStart(2, "0")}`;
        timesArray.push(formattedTime);
      }
    }
    return timesArray;
  };

  const times = generateTimes();

  return (
    <section className="py-16 px-4">
      <motion.div 
        initial={{ opacity: 0, y: 30 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.8 }}
        className="max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border-2 border-gray-100"
      >
        <div className="p-10">
          <motion.h2 
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ delay: 0.3, duration: 0.5 }}
            className="text-4xl font-extrabold mb-8 text-center text-gray-800"
          >
            Find Your <span className="text-orange-500">Perfect Ride</span>
          </motion.h2>
          
          <form onSubmit={opensearch} className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
            <motion.div 
              initial={{ opacity: 0, x: -20 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ delay: 0.4, duration: 0.5 }}
              className="flex flex-col"
            >
              <label className="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                <FaMapMarkerAlt className="text-orange-500 mr-2" />
                ບ່ອນຮັບ-ສົ່ງລົດ *
              </label>
              <select
                value={pickUpandDropoff}
                onChange={handlePickandDropo}
                className="border-2 border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-lg shadow-sm"
              >
                <option value="">ເລືອກສະຖານທີ່</option>
                <option value="ລົດໄຟສາຍໃຕ້">ລົດໄຟສາຍໃຕ້</option>
                <option value="ສະຫນາມບິນວັດໄຕ">ສະຫນາມບິນວັດໄຕ</option>
              </select>
            </motion.div>

            <motion.div 
              initial={{ opacity: 0, x: -20 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ delay: 0.5, duration: 0.5 }}
              className="flex flex-col"
            >
              <label className="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                <FaCalendarAlt className="text-orange-500 mr-2" />
                ວັນຮັບລົດ *
              </label>
              <input
                id="picktime"
                type="date"
                value={pickTime}
                onChange={handlePickTime}
                className="border-2 border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-lg shadow-sm"
              />
            </motion.div>

            <motion.div 
              initial={{ opacity: 0, x: -20 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ delay: 0.6, duration: 0.5 }}
              className="flex flex-col"
            >
              <label className="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                <FaCalendarAlt className="text-orange-500 mr-2" />
                ວັນສົ່ງລົດ *
              </label>
              <input
                id="droptime"
                type="date"
                value={dropTime}
                onChange={handleDropTime}
                className="border-2 border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-lg shadow-sm"
              />
            </motion.div>

            <motion.div 
              initial={{ opacity: 0, x: -20 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ delay: 0.7, duration: 0.5 }}
              className="flex flex-col"
            >
              <label className="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                <FaClock className="text-orange-500 mr-2" />
                ເວລາຮັບລົດ *
              </label>
              <select 
                value={startTime} 
                onChange={handleStartTimeChange}
                className="border-2 border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-lg shadow-sm"
              >
                {times.map((time, index) => (
                  <option key={index} value={time}>
                    {time}
                  </option>
                ))}
              </select>
            </motion.div>

            <motion.div 
              initial={{ opacity: 0, x: -20 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ delay: 0.8, duration: 0.5 }}
              className="flex flex-col"
            >
              <label className="text-lg font-semibold text-gray-700 mb-3 flex items-center">
                <FaClock className="text-orange-500 mr-2" />
                ເວລາສົ່ງລົດ *
              </label>
              <select 
                value={endTime} 
                onChange={handleEndTimeChange}
                className="border-2 border-gray-300 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-lg shadow-sm"
              >
                {times.map((time, index) => (
                  <option key={index} value={time}>
                    {time}
                  </option>
                ))}
              </select>
            </motion.div>

            <motion.div 
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.9, duration: 0.5 }}
              className="sm:col-span-2 lg:col-span-5 mt-4"
            >
              <button 
                type="submit"
                className="w-full bg-orange-500 text-white font-bold py-5 px-6 rounded-xl hover:bg-orange-600 active:bg-orange-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50 text-xl shadow-lg"
              >
                Search Available Cars
              </button>
            </motion.div>
          </form>
        </div>
      </motion.div>
    </section>
  );
}

export default BookCar;
