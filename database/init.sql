USE tfgDAW2526;

CREATE TABLE restaurants (

    restaurant_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    address VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    logo_url VARCHAR(100) NOT NULL,
    primary_color VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

);

CREATE TABLE users (

    user_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'restaurateur') DEFAULT 'restaurateur',
    avatar_url TEXT,
    restaurant_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,    
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(restaurant_id)
);

CREATE TABLE menus (

    menu_id INT PRIMARY KEY AUTO_INCREMENT,
    is_active BOOLEAN DEFAULT TRUE,
    restaurant_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (restaurant_id) REFERENCES restaurants(restaurant_id)
);

CREATE TABLE categories (

    category_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    category_photo_URL TEXT,
    order_index INT UNSIGNED NOT NULL,
    menu_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (menu_id) REFERENCES menus(menu_id)
);

CREATE TABLE dishes (

    dish_id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    dish_photo_URL TEXT,
    price DECIMAL(10, 2) NOT NULL,
    is_available BOOLEAN DEFAULT TRUE,
    allergens TEXT,
    tags TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id) REFERENCES categories(category_id)

);

CREATE TABLE shifts (

    shift_id INT PRIMARY KEY AUTO_INCREMENT,
    restaurant_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    shift_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    capacity SMALLINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (restaurant_id) REFERENCES restaurants(restaurant_id)

);

CREATE TABLE bookings (

    booking_id INT PRIMARY KEY AUTO_INCREMENT,
    restaurant_id INT NOT NULL,
    shift_id INT NOT NULL,
    booking_date DATE NOT NULL,
    booking_time TIME NOT NULL,
    adult_guests TINYINT UNSIGNED NOT NULL,
    child_guests TINYINT UNSIGNED NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    contact_info VARCHAR(100) NOT NULL,
    notes TEXT,
    status ENUM('pending', 'confirmed', 'cancelled', 'seated') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (restaurant_id) REFERENCES restaurants(restaurant_id),
    FOREIGN KEY (shift_id) REFERENCES shifts(shift_id)

);

CREATE TABLE tables (

    table_id INT PRIMARY KEY AUTO_INCREMENT,
    restaurant_id INT NOT NULL,
    number TINYINT UNSIGNED NOT NULL,
    seats TINYINT UNSIGNED NOT NULL,
    status ENUM('available', 'occupied', 'reserved') DEFAULT 'available',
    position_x INT UNSIGNED NOT NULL,
    position_y INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (restaurant_id) REFERENCES restaurants(restaurant_id)

);

CREATE TABLE booking_tables (

    table_id INT NOT NULL,
    booking_id INT NOT NULL,

    PRIMARY KEY (table_id, booking_id),

    FOREIGN KEY (table_id) REFERENCES tables(table_id),
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id)

);