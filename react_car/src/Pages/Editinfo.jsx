import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';

const Editinfo = () => {
  
  const { id } = useParams(); // Extract id from the URL
  const [formData, setFormData] = useState({
    first_name: '',
    last_name: '',
    phone_number: '',
    age: '',
    email: '',
    address: '',
    village: '',
    city: '',
    province: '',
    zipcode: '',
    image: null,
  });
  const [imagePreview, setImagePreview] = useState('');
  const [errors, setErrors] = useState({});

  useEffect(() => {
    if (id) {
      const fetchUserData = async () => {
        try {
          const response = await fetch(`http://localhost:8000/api/users/${id}`);
          if (!response.ok) throw new Error('Failed to fetch user data');
          const data = await response.json();
          setFormData((prevData) => ({
            ...prevData,
            ...data,
          }));
          setImagePreview(data.image ? `/${data.image}` : '');
        } catch (error) {
          console.error('Error fetching user data:', error);
        }
      };

      fetchUserData();
    } else {
      console.error('No id provided');
    }
  }, [id]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setFormData((prevData) => ({
        ...prevData,
        image: file,
      }));
      setImagePreview(URL.createObjectURL(file));
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!id) {
      console.error('No id provided for update');
      alert('Invalid user ID. Unable to update user.');
      return;
    }

    const formDataToSubmit = new FormData();
    Object.keys(formData).forEach((key) => {
      formDataToSubmit.append(key, formData[key]);
    });

    try {
      const response = await fetch(`http://localhost:8000/api/users`, {
        method: 'PUT',
        body: formDataToSubmit,
      });

      if (!response.ok) {
        const errorText = await response.text();
        console.error('Server error:', errorText);
        alert('Error updating user');
        return;
      }

      const result = await response.json();
      alert('User updated successfully');
    } catch (error) {
      console.error('Error updating user:', error);
    }
  };
  return (
    <div className="form">
      <form onSubmit={handleSubmit} className="form-container">
        <h2 className="form-title">EDIT PERSONAL INFORMATION</h2>
        <div className="form-grid">
          <div className="form-group">
            <label>First Name *</label>
            <input
              type="text"
              name="first_name"
              placeholder="Enter your first name"
            />
            {errors.first_name && <p className="error-message">{errors.first_name}</p>}
          </div>

          <div className="form-group">
            <label>Last Name *</label>
            <input
              type="text"
              name="last_name"
              placeholder="Enter your last name"
              value={formData.last_name}
              onChange={handleChange}
            />
            {errors.last_name && <p className="error-message">{errors.last_name}</p>}
          </div>
        </div>

        <div className="form-grid">
          <div className="form-group">
            <label>Phone Number *</label>
            <input
              type="tel"
              name="phone_number"
              placeholder="Enter your phone number"
              value={formData.phone_number}
              onChange={handleChange}
            />
            {errors.phone_number && <p className="error-message">{errors.phone_number}</p>}
          </div>

          <div className="form-group">
            <label>Age *</label>
            <input
              type="number"
              name="age"
              placeholder="Enter your age"
              value={formData.age}
              onChange={handleChange}
            />
            {errors.age && <p className="error-message">{errors.age}</p>}
          </div>
        </div>

        <div className="form-group">
          <label>Email *</label>
          <input
            type="email"
            name="email"
            placeholder="Enter your email address"
            value={formData.email}
            onChange={handleChange}
          />
          {errors.email && <p className="error-message">{errors.email}</p>}
        </div>

        <div className="form-group">
          <label>Address *</label>
          <input
            type="text"
            name="address"
            placeholder="Enter your street address"
            value={formData.address}
            onChange={handleChange}
          />
          {errors.address && <p className="error-message">{errors.address}</p>}
        </div>

        <div className="form-grid">
          <div className="form-group">
            <label>Village *</label>
            <input
              type="text"
              name="village"
              placeholder="Enter your village"
              value={formData.village}
              onChange={handleChange}
            />
            {errors.village && <p className="error-message">{errors.village}</p>}
          </div>

          <div className="form-group">
            <label>City *</label>
            <input
              type="text"
              name="city"
              placeholder="Enter your city"
              value={formData.city}
              onChange={handleChange}
            />
            {errors.city && <p className="error-message">{errors.city}</p>}
          </div>

          <div className="form-group">
            <label>Province *</label>
            <input
              type="text"
              name="province"
              placeholder="Enter your province"
              value={formData.province}
              onChange={handleChange}
            />
            {errors.province && <p className="error-message">{errors.province}</p>}
          </div>

          <div className="form-group">
            <label>Zip Code *</label>
            <input
              type="text"
              name="zipcode"
              placeholder="Enter your zip code"
              value={formData.zipcode}
              onChange={handleChange}
            />
            {errors.zipcode && <p className="error-message">{errors.zipcode}</p>}
          </div>
        </div>

        <div className="form-group">
          <label>Image *</label>
          <input
            type="file"
            name="image"
            accept="image/*"
            onChange={handleImageChange}
          />
          {imagePreview && (
            <div>
              <img
                src={imagePreview}
                alt="Preview"
                style={{
                  width: '200px',
                  height: 'auto',
                  marginTop: '10px',
                }}
              />
            </div>
          )}
        </div>

        <button type="submit" className="submit-button">
          Save Changes
        </button>
      </form>
    </div>
  );
};

export default Editinfo;
