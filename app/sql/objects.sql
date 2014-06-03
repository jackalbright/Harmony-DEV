DROP TABLE IF EXISTS hd_products;
CREATE TABLE IF NOT EXISTS hd_products
(
	product_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

	prod		VARCHAR(5), # B, FS, etc...
	name		VARCHAR(16),
	plural_name	VARCHAR(16),
	rank		INTEGER UNSIGNED,

	size		VARCHAR(20),
	minimum		INTEGER UNSIGNED,
	normal_ship_time_days	INTEGER UNSIGNED,
	weight		FLOAT UNSIGNED,
	weight_count	INTEGER UNSIGNED NOT NULL DEFAULT 1,
	image_type	SET ('original_stamp', 'repro_stamp', 'custom_image', 'gallery_image'),

	main_intro	TEXT,
	main_desc	TEXT,
	secondary_desc	TEXT,
	
	meta_keywords	TEXT,
	meta_desc	TEXT,

	page_title	VARCHAR(255),
	body_title	VARCHAR(255)
);

ALTER TABLE hd_products ADD max_per_10_days INTEGER UNSIGNED DEFAULT 1000;
ALTER TABLE hd_products ADD is_stock_item BOOL DEFAULT FALSE;
ALTER TABLE hd_products ADD pricing_name VARCHAR(128);




DROP TABLE IF EXISTS hd_product_pricing;
CREATE TABLE IF NOT EXISTS hd_product_pricing
(
	pricing_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_id	INTEGER UNSIGNED,
	max_quantity	INTEGER UNSIGNED,
	pricing		FLOAT
);

DROP TABLE IF EXISTS hd_customization_options; # ie a 'step' within the customization process....
CREATE TABLE IF NOT EXISTS hd_customization_options
(
	customization_option_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	option_name	VARCHAR(64), # Tassel, etc.
	pricing		FLOAT NULL, # ie paperweight rectangle option, charm, etc.
	is_optional	BOOL
);

DROP TABLE IF EXISTS hd_product_customization_options;
CREATE TABLE IF NOT EXISTS hd_product_customization_options
(
	product_customization_option_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_id	INTEGER UNSIGNED,
	customization_option_id INTEGER UNSIGNED
);

DROP TABLE IF EXISTS hd_product_testimonials;
CREATE TABLE IF NOT EXISTS hd_product_testimonials
(
	product_testimonial_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_id	INTEGER UNSIGNED NOT NULL,
	testimonial_id	INTEGER UNSIGNED NOT NULL
);

DROP TABLE IF EXISTS hd_testimonials;
CREATE TABLE IF NOT EXISTS hd_testimonials
(
	testimonial_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	text	TEXT,
	attribution	VARCHAR(150), # Use for now, eventually transition to linking to customers once THAT is moved over...
	customer_id	INTEGER UNSIGNED
);
