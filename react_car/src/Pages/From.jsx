import { useEffect, useState } from "react";
import "../dist/styles.css";
import HeroPages from "../components/HeroPages";
import { useLocation } from "react-router-dom";
import axios from "axios";
import Swal from "sweetalert2";
import { useNavigate } from "react-router-dom";

function CarRental() {
  const location = useLocation();
  const navigate = useNavigate();
  const [carList, setCarList] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [errors, setErrors] = useState(null);
  const {
    pickUpandDropoff,
    pickTime,
    dropTime,
    startTime,
    endTime,
    days,
    total,
    index,
  } = location.state || {};

  // ອັບໂຫລດຮູບພາບ
  const [imagePreviews, setImagePreviews] = useState([]);
  const [imageFiles, setImageFiles] = useState([]);

  const handleImageChange = (e) => {
    const files = e.target.files;

    const newImageFiles = [];
    const newImagePreviews = [];

    // ອ່ານໄຟລ໌ຮູບພາບແລະສ້າງ URL ສຳລັບສະແດງຕົວຢ່າງ
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();

      reader.onloadend = () => {
        newImagePreviews.push({
          id: URL.createObjectURL(file),
          url: reader.result,
        }); // ສ້າງ ID ສະເພາະ
        newImageFiles.push(file);

        // ອັບເດດ state ເມື່ອອ່ານໄຟລ໌ສຳເລັດ
        if (newImagePreviews.length === files.length) {
          setImagePreviews([...imagePreviews, ...newImagePreviews]);
          setImageFiles([...imageFiles, ...newImageFiles]);
        }
      };

      reader.readAsDataURL(file);
    }
  };

  const handleDeleteImage = (id) => {
    const updatedPreviews = imagePreviews.filter(
      (preview) => preview.id !== id
    );
    const updatedFiles = imageFiles.filter(
      (_, i) => imagePreviews[i].id !== id
    );

    setImagePreviews(updatedPreviews);
    setImageFiles(updatedFiles);
  };

  // ສ້າງຟອມ
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [phone, setPhone] = useState("");
  const [age, setAge] = useState("");
  const [email, setEmail] = useState("");
  const [country, setCountry] = useState("");
  const [address, setAddress] = useState("");
  const [city, setCity] = useState("");
  const [zipcode, setZipcode] = useState("");
  
  // ຕົວຈັດການສຳລັບແຕ່ລະຊ່ອງປ້ອນຂໍ້ມູນ
  const handleFirstNameChange = (e) => {
    setFirstName(e.target.value);
  };
  
  const handleLastNameChange = (e) => {
    setLastName(e.target.value);
  };
  
  const handlePhoneChange = (e) => {
    setPhone(e.target.value);
  };
  
  const handleAgeChange = (e) => {
    setAge(e.target.value);
  };
  
  const handleEmailChange = (e) => {
    setEmail(e.target.value);
  };
  
  const handleCountryChange = (e) => {
    setCountry(e.target.value);
  };
  
  const handleAddressChange = (e) => {
    setAddress(e.target.value);
  };
  
  const handleCityChange = (e) => {
    setCity(e.target.value);
  };
  
  const handleZipcodeChange = (e) => {
    setZipcode(e.target.value);
  };
  
  const handleConfirmation = (e) => {
    e.preventDefault();
    Swal.fire({
      title: 'ຕ້ອງການຈອງແທ້ບໍ່?',
      text: "ການກະທຳນີ້ສາມາດຍົກເລີກໄດ້!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ຕົກລົງ',
      cancelButtonText: 'ຍົກເລີກ'
    }).then((result) => {
      if (result.isConfirmed) {
        handleSubmit(e); // ເອີ້ນ handleSubmit ໂດຍບໍ່ມີ event
      }
    });
  };
  
  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!firstName.trim()) {
      setError("ກະລຸນາປ້ອນຊື່.");
      return;
    } else if (!lastName.trim()) {
      setError("ກະລຸນາປ້ອນນາມສະກຸນ.");
      return;
    } else if (!phone.trim() || phone.length !== 11) {
      setError("ເບີໂທຕ້ອງມີ 11 ຕົວເລກ.");
      return;
    } else if (!age.trim() || age <= 17) {
      setError("ອາຍຸຕ້ອງ 18 ປີຂຶ້ນໄປ.");
      return;
    }else if (!email.trim()) {
      setError("ກະລຸນາປ້ອນອີເມວ.");
      return;
    }else if (!country.trim()) {
      setError("ກະລຸນາປ້ອນປະເທດ.");
      return;
    }else if (!address.trim()) {
      setError("ກະລຸນາປ້ອນທີ່ຢູ່.");
      return;
    }else if (!city.trim()) {
      setError("ກະລຸນາປ້ອນເມືອງ.");
      return;
    }else if (!zipcode.trim()) {
      setError("ກະລຸນາປ້ອນລະຫັດໄປສະນີ.");
      return;
    } else if (imageFiles.length === 0) {
      setError("ກະລຸນາອັບໂຫລດຮູບພາບຢ່າງໜ້ອຍໜຶ່ງຮູບ.");
      return;
    }  
    const formData = new FormData();
    formData.append('first_name', firstName);
    formData.append('last_name', lastName);
    formData.append('phone_number', phone);
    formData.append('age', age);
    formData.append('email', email);
    formData.append('country', country);
    formData.append('city', city);
    formData.append('address', address);
    formData.append('zipcode', parseInt(zipcode, 10) || 0);
    formData.append('image', imageFiles[0]);
    //booking
    formData.append('car_id', index);
    formData.append('pick_up_and_dropoff', pickUpandDropoff);
    formData.append('pick_time', pickTime);
    formData.append('drop_time', dropTime);
    formData.append('start_time', startTime);
    formData.append('end_time', endTime);
    formData.append('days', days);
    formData.append('total', total);


  try {
    Swal.fire({
      title: "ກຳລັງສົ່ງຂໍ້ມູນ...",
      text: "ກະລຸນາຖ້າ",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    // ສົ່ງຂໍ້ມູນໄປຫາ API
    const response = await fetch("http://localhost:8000/api/form", {
      method: "POST",
      body: formData,
      headers: {
        'Accept': 'application/json',
        // ບໍ່ຕ້ອງກຳນົດ Content-Type ເມື່ອໃຊ້ FormData
        // ເບາວເຊີຈະກຳນົດ Content-Type: multipart/form-data ແລະ boundary ໃຫ້ອັດຕະໂນມັດ
      },
    });

    // ກວດສອບຄຳຕອບຈາກ API
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'ມີຂໍ້ຜິດພາດໃນການສົ່ງຂໍ້ມູນ');
    }

    const data = await response.json();
    Swal.fire({
      icon: "success",
      title: "ສົ່ງຂໍ້ມູນສຳເລັດ!",
      text: "ຂໍ້ມູນຂອງທ່ານໄດ້ຖືກບັນທຶກໄວ້.",
      confirmButtonText: "ຕົກລົງ",
    }).then(() => {
      navigate("/");
    });

    // console.log("User created:", data);
  } catch (errors) {
    console.error("Error submitting form:", errors);
    setErrors(errors.message);

    Swal.fire({
      icon: "error",
      title: "ເກີດຄວາມຜິດພາດຂຶ້ນ.",
      text: errors.message || "Email ຫຼື Phone ຊ້ຳ",
      confirmButtonText: "ລອງອີກຄັ້ງ",
    });
  }
  };

  const fetchCars = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/cars");
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
  useEffect(() => {
    fetchCars();
  }, []);
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
        setError(null);
      });
    }
  }, [error]);

  if (loading || error) {
    return null;
  }
  return (
    <>
      <HeroPages name="ເຊົ່າ" />
      <div className="info-from">
        <div className="car-rental-container">
          {carList
            .filter((car) => car.car_id === index) // ກອງສະເພາະລົດທີ່ຕົງກັບ car_id
            .map((car) => (
              <div key={car.car_id} className="car-rental-card">
                <h2>{car.car_name}</h2>
                <div className="car-images">
                  <img src={`http://localhost:8000/${car.image}`}alt={car.car_name} />
                </div>
                <div className="car-details">
                  <h3>ລາຍລະອຽດ</h3>
                  <ul>
                    <li>ປະເພດ: {car.car_type_name}</li>
                    <li>ລາຄາຕໍ່ມື້: {car.price_daily} ກີບ</li>
                    <li>
                      ລາຄາລວມ: {days} ມື້ {total} ກີບ
                    </li>
                    <li>ສະຖານະ: {car.car_status === "Available" ? "ມີພ້ອມ" : "ບໍ່ມີພ້ອມ"}</li>
                  </ul>
                </div>
                <div className="car-info">
                  <div>
                    <h1>ຢືນຢັນລາຍລະອຽດການຈອງຂອງທ່ານ</h1>
                    <div>
                      <p>
                        <strong>ບ່ອນຮັບ-ສົ່ງລົດ:</strong>{" "}
                        {pickUpandDropoff || "ບໍ່ມີຂໍ້ມູນ"}
                      </p>
                      <p>
                        <strong>ວັນຮັບລົດ:</strong> {pickTime || "ບໍ່ມີຂໍ້ມູນ"}
                      </p>
                      <p>
                        <strong>ວັນສົ່ງລົດ:</strong>{" "}
                        {dropTime || "ບໍ່ມີຂໍ້ມູນ"}
                      </p>
                      <p>
                        <strong>ເວລາຮັບລົດ:</strong>{" "}
                        {startTime || "ບໍ່ມີຂໍ້ມູນ"}
                      </p>
                      <p>
                        <strong>ເວລາສົ່ງລົດ:</strong>{" "}
                        {endTime || "ບໍ່ມີຂໍ້ມູນ"}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            ))}
        </div>
        <div className="from">
          <form onSubmit={handleConfirmation} className="form-container">
            <h2 className="form-title">ຂໍ້ມູນສ່ວນຕົວ</h2>
            <div className="form-group">
              <label>ຊື່ *</label>
              <input
                type="text"
                name="first_name"
                placeholder="ປ້ອນຊື່ຂອງທ່ານ"
                value={firstName}
                onChange={handleFirstNameChange}
                style={{ zIndex: 100, position: 'relative' }}
              />
              {error && error.includes("ຊື່") && (
                <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
              )}
            </div>

            <div className="form-group">
              <label>ນາມສະກຸນ *</label>
              <input
                type="text"
                name="last_name"
                placeholder="ປ້ອນນາມສະກຸນຂອງທ່ານ"
                value={lastName}
                onChange={handleLastNameChange}
                style={{ zIndex: 100, position: 'relative' }}
              />
              {error && error.includes("ນາມສະກຸນ") && (
                <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
              )}
            </div>

            <div className="form-grid">
              <div className="form-group">
                <label>ເບີໂທລະສັບ *</label>
                <input
                  type="tel"
                  name="phone_number"
                  placeholder="ປ້ອນເບີໂທລະສັບຂອງທ່ານ"
                  value={phone}
                  onChange={handlePhoneChange}
                />
                {error && error.includes("ເບີໂທ") && (
                  <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
                )}
              </div>

              <div className="form-group">
                <label>ອາຍຸ *</label>
                <input
                  type="text" inputmode="numeric" pattern="[0-9]*"
                  name="age"
                  placeholder="ປ້ອນອາຍຸຂອງທ່ານ"
                  value={age}
                  onChange={handleAgeChange}
                />
                {error && error.includes("ອາຍຸ") && (
                  <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
                )}
              </div>
            </div>
            <div className="form-group">
              <label>ອີເມວ *</label>
              <input
                type="email"
                name="email"
                placeholder="ປ້ອນທີ່ຢູ່ອີເມວຂອງທ່ານ"
                value={email}
                onChange={handleEmailChange}
              />
              {error && error.includes("ອີເມວ") && (
                <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
              )}
            </div>
            <div className="form-group">
              <label>ປະເທດ *</label>
              <input
                type="text"
                name="Country"
                placeholder="ປ້ອນປະເທດຂອງທ່ານ"
                value={country}
                onChange={handleCountryChange}
              />
              {error && error.includes("ປະເທດ") && (
                <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
              )}
            </div>
            <div className="form-group">
              <label>ທີ່ຢູ່ *</label>
              <input
                type="text"
                name="address"
                placeholder="ປ້ອນທີ່ຢູ່ຂອງທ່ານ"
                value={address}
                onChange={handleAddressChange}
              />
              {error && error.includes("ທີ່ຢູ່") && (
                <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
              )}
            </div>
              <div className="form-group">
                <label>ເມືອງ *</label>
                <input
                  type="text"
                  name="city"
                  placeholder="ປ້ອນເມືອງຂອງທ່ານ"
                  value={city}
                  onChange={handleCityChange}
                />
                {error && error.includes("ເມືອງ") && (
                  <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
                )}
              </div>
              <div className="form-group">
                <label>ລະຫັດໄປສະນີ *</label>
                <input
                  type="number"
                  name="zipcode"
                  placeholder="ປ້ອນລະຫັດໄປສະນີຂອງທ່ານ"
                  value={zipcode}
                  onChange={handleZipcodeChange}
                />
                {error && error.includes("ລະຫັດໄປສະນີ") && (
                  <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
                )}
              </div>
            <div className="form-group">
              <label>ຮູບບັດ</label>
              <input
                type="file"
                name="image"
                accept="image/*"
                onChange={handleImageChange}
                multiple // ອະນຸຍາດໃຫ້ເລືອກຫຼາຍໄຟລ໌
                disabled={imageFiles.length >= 1} // ປິດການໃຊ້ງານ input ຫາກມີຮູບພາບຄົບ 1 ຮູບແລ້ວ
              />
              <div
                style={{ display: "flex", flexWrap: "wrap", marginTop: "10px" }}
              >
                {imagePreviews.map((preview) => (
                  <div
                    key={preview.id}
                    style={{
                      marginRight: "10px",
                      marginBottom: "10px",
                      display: "flex",
                      flexDirection: "column",
                      alignItems: "center",
                    }}
                  >
                    <img
                      src={preview.url}
                      alt={`Preview`}
                      style={{
                        width: "200px",
                        height: "auto",
                      }}
                    />
                    <button
                      onClick={() => handleDeleteImage(preview.id)}
                      style={{
                        marginTop: "5px",
                        padding: "5px 10px",
                        backgroundColor: "#ff4d4f",
                        color: "#fff",
                        border: "none",
                        borderRadius: "5px",
                        cursor: "pointer",
                        width: "100%",
                      }}
                    >
                      ລຶບຮູບ
                    </button>
                  </div>
                ))}
              </div>
            </div>

            <button type="submit" className="submit-button">
              ສົ່ງຂໍ້ມູນ
            </button>
          </form>
        </div>
      </div>
    </>
  );
}

export default CarRental;
