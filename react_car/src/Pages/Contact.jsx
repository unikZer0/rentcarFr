import { useState } from "react";
import Footer from "../components/Footer";
import HeroPages from "../components/HeroPages";
import Swal from "sweetalert2";

function Contact() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [message, setMessage] = useState("");
  const [error, setError] = useState(null);

  const handleSubmit = async (e) => {
    e.preventDefault();

    // Validate form fields
    if (!name.trim()) {
      setError("ກະລຸນາປ້ອນຊື່ຂອງທ່ານ");
      return;
    } else if (!email.trim()) {
      setError("ກະລຸນາປ້ອນອີເມວຂອງທ່ານ");
      return;
    } else if (!message.trim()) {
      setError("ກະລຸນາປ້ອນລາຍລະອຽດ");
      return;
    }

    try {
      Swal.fire({
        title: "ກຳລັງສົ່ງຂໍ້ມູນ...",
        text: "ກະລຸນາຖ້າ",
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });

      // Send data to API
      const response = await fetch("http://localhost:8000/api/contact", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
        },
        body: JSON.stringify({
          name,
          email,
          message,
        }),
      });

      // Check response from API
      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'ມີຂໍ້ຜິດພາດໃນການສົ່ງຂໍ້ມູນ');
      }

      const data = await response.json();
      
      // Show success message
      Swal.fire({
        icon: "success",
        title: "ສົ່ງຂໍ້ມູນສຳເລັດ!",
        text: "ຂໍ້ຄວາມຂອງທ່ານໄດ້ຖືກສົ່ງແລ້ວ. ພວກເຮົາຈະຕິດຕໍ່ກັບທ່ານໄວໆນີ້.",
        confirmButtonText: "ຕົກລົງ",
      });

      // Clear form fields
      setName("");
      setEmail("");
      setMessage("");
      setError(null);

    } catch (error) {
      console.error("Error submitting form:", error);

      Swal.fire({
        icon: "error",
        title: "ເກີດຄວາມຜິດພາດຂຶ້ນ",
        text: error.message || "ບໍ່ສາມາດສົ່ງຂໍ້ຄວາມໄດ້. ກະລຸນາລອງໃໝ່ອີກຄັ້ງ.",
        confirmButtonText: "ລອງອີກຄັ້ງ",
      });
    }
  };

  return (
    <>
      <section className="contact-page">
        <HeroPages name="ຕິດຕໍ່" />
        <div className="container">
          <div className="contact-div">
            <div className="contact-div__text">
              <h2>ກ່ຽວກັບພວກເຮົາ</h2>
              <p>
               ເປັນເວັບທີ່ສ້າງຂຶ້ນເພື່ອເປັນ project ວິຊາ php2+ framework ເຊິ່ງສອນໂດຍ ອຈ ມົນພິນ
               <br />
               ພັດທະນາໂດຍໃຊ້ laravel + react 
              </p>
              <a href="/">
                <i className="fa-solid fa-phone"></i>&nbsp;(+856) 2096108100
              </a>
              <a href="/">
                <i className="fa-solid fa-envelope"></i>&nbsp;
                unik09john@gmail.com
              </a>
              <a href="/">
                <i className="fa-solid fa-location-dot"></i>&nbsp; ມະຫາວິທະຍາໄລແຫ່ງຊາດ,
                ດົງໂດກ
              </a>
            </div>
            <div className="contact-div__form">
              <form onSubmit={handleSubmit}>
                {error && <p style={{ color: "red", fontSize: "14px" }}>{error}</p>}
                <label>
                  ຊື່ຂອງທ່ານ <b>*</b>
                </label>
                <input 
                  type="text" 
                  placeholder='ທ້າວ: "ຢູນິກ"'
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                />

                <label>
                  ອີເມວຂອງທ່ານ <b>*</b>
                </label>
                <input 
                  type="email" 
                  placeholder="youremail@example.com"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                />

                <label>
                  ລາຍລະອຽດ <b>*</b>
                </label>
                <textarea 
                  placeholder="ຂຽນບ່ອນນີ້.."
                  value={message}
                  onChange={(e) => setMessage(e.target.value)}
                />

                <button type="submit">
                  <i className="fa-solid fa-envelope-open-text"></i>&nbsp; ສົ່ງຂໍ້ຄວາມ
                </button>
              </form>
            </div>
          </div>
        </div>
        <div className="book-banner">
          <div className="book-banner__overlay"></div>
          <div className="container">
            <div className="text-content">
              <h2>ຕິດຕໍ່ເພີ່ມເຕີມ</h2>
              <span>
                <i className="fa-solid fa-phone"></i>
                <h3>(+856) 2096108100</h3>
              </span>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}

export default Contact;
