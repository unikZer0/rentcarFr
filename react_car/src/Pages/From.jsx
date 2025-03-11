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

  // upimage
  const [imagePreviews, setImagePreviews] = useState([]);
  const [imageFiles, setImageFiles] = useState([]);

  const handleImageChange = (e) => {
    const files = e.target.files;

    const newImageFiles = [];
    const newImagePreviews = [];

    // อ่านไฟล์รูปภาพและสร้าง URL สำหรับแสดงตัวอย่าง
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();

      reader.onloadend = () => {
        newImagePreviews.push({
          id: URL.createObjectURL(file),
          url: reader.result,
        }); // สร้าง ID เฉพาะ
        newImageFiles.push(file);

        // อัปเดต state เมื่ออ่านไฟล์เสร็จ
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

  // สร้างฟอร์ม
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [phone, setPhone] = useState("");
  const [age, setAge] = useState("");
  const [email, setEmail] = useState("");
  const [country, setCountry] = useState("");
  const [address, setAddress] = useState("");
  const [city, setCity] = useState("");
  const [zipcode, setZipcode] = useState("");
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
  const handleSubmit = async  (e) => {
    e.preventDefault();

    if (!firstName.trim()) {
      setError("First Name is required.");
      return;
    } else if (!lastName.trim()) {
      setError("last Name is required.");
      return;
    } else if (!phone.trim() || phone.length !== 11) {
      setError("phone is required 11.");
      return;
    } else if (!age.trim() || age <= 17) {
      setError("age is required 18+.");
      return;
    }else if (!email.trim()) {
      setError("email is required.");
      return;
    }else if (!country.trim()) {
      setError("country is required.");
      return;
    }else if (!address.trim()) {
      setError("address is required.");
      return;
    }else if (!city.trim()) {
      setError("city is required.");
      return;
    }else if (!zipcode.trim()) {
      setError("zipcode is required.");
      return;
    } else if (imageFiles.length === 0) {
      setError("Please upload at least one image.");
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

    const response = await fetch("http://localhost:8000/api/form", {
      method: "POST",
      body: formData,
      headers: {
        Accept: "application/json",
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(errorText);
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
      text: "Email ຫຼື Phone ຊ້ຳ",
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
        throw new Error("Invalid data format received from the server");
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
            .filter((car) => car.car_id === index) // กรองเฉพาะรถที่ตรงกับ car_id
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
                    <li>ສະຖານະ: {car.car_status}</li>
                  </ul>
                </div>
                <div className="car-info">
                  <div>
                    <h1>Confirm Your Booking Details</h1>
                    <div>
                      <p>
                        <strong>ບ່ອນຮັບ-ສົ່ງລົດ:</strong>{" "}
                        {pickUpandDropoff || "Not Provided"}
                      </p>
                      <p>
                        <strong>ວັນຮັບລົດ:</strong> {pickTime || "Not Provided"}
                      </p>
                      <p>
                        <strong>ວັນສົ່ງລົດ:</strong>{" "}
                        {dropTime || "Not Provided"}
                      </p>
                      <p>
                        <strong>ເວລາຮັບລົດ:</strong>{" "}
                        {startTime || "Not Provided"}
                      </p>
                      <p>
                        <strong>ເວລາສົ່ງລົດ:</strong>{" "}
                        {endTime || "Not Provided"}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            ))}
        </div>
        <div className="from">
          <form onSubmit={handleConfirmation} className="form-container">
            <h2 className="form-title">PERSONAL INFORMATION</h2>
            <div className="form-group">
              <label>First Name *</label>
              <input
                type="text"
                name="first_name"
                placeholder="Enter your first name"
                value={firstName}
                onChange={(e) => setFirstName(e.target.value)}
              />{" "}
              {error && (
                <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
              )}
            </div>

            <div className="form-group">
              <label>Last Name *</label>
              <input
                type="text"
                name="last_name"
                placeholder="Enter your last name"
                value={lastName}
                onChange={(e) => setLastName(e.target.value)}
              />
              {error && (
                <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
              )}
            </div>

            <div className="form-grid">
              <div className="form-group">
                <label>Phone Number *</label>
                <input
                  type="tel"
                  name="phone_number"
                  placeholder="Enter your phone number"
                  value={phone}
                  onChange={(e) => setPhone(e.target.value)}
                />
                {error && (
                  <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
                )}
              </div>

              <div className="form-group">
                <label>Age *</label>
                <input
                  type="text" inputmode="numeric" pattern="[0-9]*"
                  name="age"
                  
                  placeholder="Enter your age"
                  value={age}
                  onChange={(e) => setAge(e.target.value)}
                />
                {error && (
                  <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
                )}
              </div>
            </div>
            <div className="form-group">
              <label>email *</label>
              <input
                type="email"
                name="email"
                placeholder="Enter your email address"
                value={email}
                  onChange={(e) => setEmail(e.target.value)}
              />
                              {error && (
                  <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
                )}
            </div>
            <div className="form-group">
              <label>Country *</label>
              <input
                type="text"
                name="Country"
                placeholder="Enter your Country"
                value={country}
                  onChange={(e) => setCountry(e.target.value)}
              />
                             {error && (
                  <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
                )}
            </div>
            <div className="form-group">
              <label>Address *</label>
              <input
                type="text"
                name="address"
                placeholder="Enter your street address"
                value={address}
                onChange={(e) => setAddress(e.target.value)}
              />
                              {error && (
                  <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
                )}
            </div>
              <div className="form-group">
                <label>City *</label>
                <input
                  type="text"
                  name="city"
                  placeholder="Enter your city"
                  value={city}
                  onChange={(e) => setCity(e.target.value)}
                />
                                {error && (
                  <p style={{ color: "red", fontSize: "14px" }}>{error}</p>
                )}
              </div>
              <div className="form-group">
                <label>Post code *</label>
                <input
                  type="number"
                  name="zipcode"
                  placeholder="Enter your zip code"
                  value={zipcode}
                  onChange={(e) => setZipcode(e.target.value)}
                />
                {error && (
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
                multiple // อนุญาตให้เลือกหลายไฟล์
                disabled={imageFiles.length >= 1} // ปิดการใช้งาน input หากมีรูปภาพครบ 3 รูปแล้ว
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
              Submit
            </button>
          </form>
        </div>
      </div>
    </>
  );
}

export default CarRental;
