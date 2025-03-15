import React from 'react';
import { Link } from 'react-router-dom';
import { FaPhone, FaEnvelope, FaFacebook, FaTwitter, FaInstagram, FaLinkedin } from 'react-icons/fa';

function Footer() {
  return (
    <footer className="bg-gray-900 text-white pt-16 pb-8 mt-3">
      <div className="container mx-auto px-4">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {/* ຂໍ້ມູນບໍລິສັດ */}
          <div className="mb-8">
            <h2 className="text-2xl font-bold mb-4">
              <span className="text-orange-500">ເຊົ່າ</span> ລົດ
            </h2>
            <p className="text-gray-400 mb-4">
              ພວກເຮົາມີລົດຫຼາກຫຼາຍປະເພດສຳລັບທຸກຄວາມຕ້ອງການໃນການຂັບຂີ່ຂອງທ່ານ. ພວກເຮົາມີລົດທີ່ເໝາະສົມເພື່ອຕອບສະໜອງຄວາມຕ້ອງການຂອງທ່ານ.
            </p>
            <h3>ຕິດຕໍ່ຂອງຢູນິກ</h3>
            <div className="flex space-x-4 mt-6">
              <a href="https://web.facebook.com/unik.csp" className="text-gray-400 hover:text-orange-500 transition-colors">
                <FaFacebook size={24} />
              </a>
              <a href="https://x.com/NickCsp19" className="text-gray-400 hover:text-orange-500 transition-colors">
                <FaTwitter size={24} />
              </a>
              <a href="https://www.instagram.com/unik_n0/" className="text-gray-400 hover:text-orange-500 transition-colors">
                <FaInstagram size={24} />
              </a>
            </div>
          </div>

          {/* ລິ້ງຂອງບໍລິສັດ */}
          <div className="mb-8">
            <h3 className="text-xl font-bold mb-4 text-orange-500">ບໍລິສັດ</h3>
            <ul className="space-y-2">
              <li>
                <Link to="/" className="text-gray-400 hover:text-white transition-colors">ໜ້າຫຼັກ</Link>
              </li>
              <li>
                <Link to="/booking" className="text-gray-400 hover:text-white transition-colors">ເຊົ່າລົດ</Link>
              </li>
              <li>
                <Link to="/team" className="text-gray-400 hover:text-white transition-colors">ກ່ຽວກັບພວກເຮົາ</Link>
              </li>
              <li>
                <Link to="/contact" className="text-gray-400 hover:text-white transition-colors">ຕິດຕໍ່</Link>
              </li>
            </ul>
          </div>

          {/* ເວລາເຮັດວຽກ */}
          <div className="mb-8">
            <h3 className="text-xl font-bold mb-4 text-orange-500">ເວລາເຮັດວຽກ</h3>
            <ul className="space-y-2 text-gray-400">
              <li className="flex justify-between">
                <span>ຈັນ - ສຸກ:</span>
                <span>9:00 - 21:00</span>
              </li>
              <li className="flex justify-between">
                <span>ເສົາ:</span>
                <span>9:00 - 19:00</span>
              </li>
              <li className="flex justify-between">
                <span>ອາທິດ:</span>
                <span>ປິດ</span>
              </li>
            </ul>
            <div className="mt-6 space-y-3">
              <a href="tel:+85620XXXXXXXX" className="flex items-center text-gray-400 hover:text-white transition-colors">
                <FaPhone className="mr-2" /> +856 20 XXXX XXXX
              </a>
              <a href="mailto:info@carrental.com" className="flex items-center text-gray-400 hover:text-white transition-colors">
                <FaEnvelope className="mr-2" /> info@carrental.com
              </a>
            </div>
          </div>

          {/* ຮັບຂ່າວສານ */}
          <div className="mb-8">
            <h3 className="text-xl font-bold mb-4 text-orange-500">ຮັບຂ່າວສານ</h3>
            <p className="text-gray-400 mb-4">
              ລົງທະບຽນອີເມວຂອງທ່ານເພື່ອຮັບຂ່າວສານແລະການອັບເດດລ່າສຸດ.
            </p>
            <form className="mt-4">
              <div className="flex flex-col space-y-3">
                <input 
                  type="email" 
                  placeholder="ປ້ອນທີ່ຢູ່ອີເມວ" 
                  className="bg-gray-800 text-white px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                />
                <button 
                  type="submit" 
                  className="bg-orange-500 text-white px-4 py-3 rounded-md hover:bg-orange-600 transition-colors font-medium"
                >
                  ສະໝັກ
                </button>
              </div>
            </form>
          </div>
        </div>

        <div className="border-t border-gray-800 mt-12 pt-8">
          <div className="flex flex-col md:flex-row justify-between items-center">
            <p className="text-gray-500 text-sm mb-4 md:mb-0">
              &copy; {new Date().getFullYear()} ເຊົ່າລົດ. ສະຫງວນລິຂະສິດທັງໝົດ.
            </p>
            <div className="flex space-x-6">
              <a href="#" className="text-gray-500 hover:text-white text-sm transition-colors">ນະໂຍບາຍຄວາມເປັນສ່ວນຕົວ</a>
              <a href="#" className="text-gray-500 hover:text-white text-sm transition-colors">ເງື່ອນໄຂການໃຊ້</a>
              <a href="#" className="text-gray-500 hover:text-white text-sm transition-colors">ຄຳຖາມທີ່ພົບເລື້ອຍ</a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
}

export default Footer;
