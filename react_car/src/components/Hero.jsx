import { Link } from "react-router-dom";
import BgShape from "../images/hero/hero-bg.png";
import HeroCar from "../images/hero/main-car.png";
import { useEffect, useState } from "react";

function Hero() {
  const [goUp, setGoUp] = useState(false);

  const scrollToTop = () => {
    window.scrollTo({ top: (0, 0), behavior: "smooth" });
  };

  const bookBtn = () => {
    document
      .querySelector("#booking-section")
      .scrollIntoView({ behavior: "smooth" });
  };

  useEffect(() => {
    const onPageScroll = () => {
      if (window.pageYOffset > 600) {
        setGoUp(true);
      } else {
        setGoUp(false);
      }
    };
    window.addEventListener("scroll", onPageScroll);

    return () => {
      window.removeEventListener("scroll", onPageScroll);
    };
  }, []);
  return (
    <>
      <section id="home" className="hero-section">
        <div className="container">
          <img className="bg-shape" src={BgShape} alt="bg-shape" />
          <div className="hero-content">
            <div className="hero-content__text">
              <h4>ວາງແຜນການເດີນທາງຂອງເຈົ້າດຽວນີ້</h4>
              <h1>
              ຊອກຫາ <span>ລົດເຊົ່າ</span> ລາຄາຖືກທີ່ສຸດ
              </h1>
              <p>
              ເຊົ່າລົດໃນຄວາມຝັນຂອງເຈົ້າ. ລາຄາທີ່ບໍ່ແພງ, ໄມລ໌ບໍ່ຈຳກັດ, ທາງເລືອກໃນການຮັບເອົາແບບຍືດຫຍຸ່ນ ແລະ ອື່ນໆອີກ.
              </p>
              <div className="hero-content__text__btns">
                <Link
                  onClick={bookBtn}
                  className="hero-content__text__btns__book-ride"
                  to="/"
                >
                  Book Ride &nbsp; <i className="fa-solid fa-circle-check"></i>
                </Link>
                <Link className="hero-content__text__btns__learn-more" to="/">
                  Learn More &nbsp; <i className="fa-solid fa-angle-right"></i>
                </Link>
              </div>
            </div>

            {/* img */}
            <img
              src={HeroCar}
              alt="car-img"
              className="hero-content__car-img"
            />
          </div>
        </div>

        {/* page up */}
        <div
          onClick={scrollToTop}
          className={`scroll-up ${goUp ? "show-scroll" : ""}`}
        >
          <i className="fa-solid fa-angle-up"></i>
        </div>
      </section>
    </>
  );
}

export default Hero;
