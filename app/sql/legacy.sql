ALTER TABLE product_type ADD is_popular BOOL DEFAULT FALSE, ADD popularity INTEGER UNSIGNED DEFAULT NULL;

UPDATE product_type SET is_popular = 1 WHERE code IN ('B','PW','MG','MM','KC','TB');

UPDATE product_type SET popularity = 0 WHERE code = 'B';
UPDATE product_type SET popularity = 1 WHERE code = 'PW';
UPDATE product_type SET popularity = 2 WHERE code = 'MG';
UPDATE product_type SET popularity = 3 WHERE code = 'MM';
UPDATE product_type SET popularity = 4 WHERE code = 'KC';
UPDATE product_type SET popularity = 5 WHERE code = 'TB';


###############
ALTER TABLE product_type ADD prod VARCHAR(32);
UPDATE product_type SET prod = LOWER(name);

 update product_type set prod = 'bookmark' where product_type_id = 2;
 update product_type set prod = 'bagtag' where product_type_id = 3;
 update product_type set prod = 'paperweight' where product_type_id = 4;
 update product_type set prod = 'framedstamp' where product_type_id = 5;
 update product_type set prod = 'magnet' where product_type_id = 7;
 update product_type set prod = 'pin' where product_type_id = 9;
 update product_type set prod = 'magnet' where product_type_id = 11;
 update product_type set prod = 'ruler' where product_type_id = 12;
 update product_type set prod = 'paperweight' where product_type_id = 13;      
 update product_type set prod = 'paperweightkit' where product_type_id = 14;
 update product_type set prod = 'keychain' where product_type_id = 15;
 update product_type set prod = 'stamp-on-card' where product_type_id = 16;
 update product_type set prod = 'tassel' where product_type_id = 17;
 update product_type set prod = 'paperweightkit' where product_type_id = 19;
 update product_type set prod = 'mug' where product_type_id = 20;
 update product_type set prod = 'poster' where product_type_id = 21;
 update product_type set prod = 'customruler' where product_type_id = 23;
 update product_type set prod = 'paperweightkit' where product_type_id = 24;
 update product_type set prod = 'poster' where product_type_id = 25;


############################################
ALTER TABLE product_type 
	ADD main_intro TEXT,
	ADD main_desc TEXT,
	ADD secondary_desc TEXT,

	ADD meta_keywords TEXT,
	ADD meta_desc TEXT,

	ADD page_title VARCHAR(255),
	ADD body_title VARCHAR(255),
	
	ADD is_stock_item BOOL DEFAULT FALSE;

ALTER TABLE product_type
	ADD minimum INTEGER UNSIGNED NOT NULL DEFAULT 1,
	ADD normal_ship_time_days INTEGER UNSIGNED NOT NULL DEFAULT 2,
	ADD max_per_10_days INTEGER UNSIGNED NOT NULL DEFAULT 1000
	;

ALTER TABLE product_type
	ADD pricing_name VARCHAR(128);
UPDATE product_type SET pricing_name = name;

	
###################################
ALTER TABLE pricePoint DROP primary key, ADD price_point_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;

ALTER TABLE pricePoint ADD product_type_id INTEGER UNSIGNED;
UPDATE pricePoint, product_type SET pricePoint.product_type_id = product_type.product_type_id WHERE pricePoint.productCode = product_type.code;

##################################
ALTER TABLE product_type ADD parent_product_type_id INTEGER UNSIGNED;

UPDATE product_type SET parent_product_type_id = 1 WHERE product_type_id = 2;
UPDATE product_type SET parent_product_type_id = 13 WHERE product_type_id = 4;
UPDATE product_type SET parent_product_type_id = 13 WHERE product_type_id = 24;
UPDATE product_type SET parent_product_type_id = 14 WHERE product_type_id = 19;



#################################
UPDATE product_type SET is_stock_item = 1 WHERE code IN ('TA','PR','MDPWK','PWK','DPWK','CH');


ALTER TABLE product_type ADD made_in_usa BOOL DEFAULT 1;

###################################
ALTER TABLE custom_image ADD session_id VARCHAR(255);

###################################
DROP TABLE IF EXISTS hd_page_folders;
CREATE TABLE IF NOT EXISTS hd_page_folders
(
	folder_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	folder_url VARCHAR(255),
	folder_name VARCHAR(64),
	parent_folder_id INTEGER UNSIGNED
);

###################################
DROP TABLE IF EXISTS hd_static_pages;
CREATE TABLE IF NOT EXISTS hd_static_pages 
(
	static_page_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	page_name VARCHAR(64),
	folder_id INTEGER UNSIGNED,
	page_title VARCHAR(255),
	body_title VARCHAR(255),
	meta_desc VARCHAR(255),
	meta_keywords VARCHAR(255),
	style	TEXT,
	full_width BOOL DEFAULT TRUE,
	content TEXT
);

####################################
ALTER TABLE browse_node
	ADD meta_desc VARCHAR(255),
	ADD meta_keywords VARCHAR(255),
	ADD description TEXT;

UPDATE browse_node SET meta_desc = CONCAT(browse_name, " gifts by Harmony Designs Inc. - Bookmarks, Paperweights, Magnets and more.");


# FOR 3/11:
####################################
ALTER TABLE part_type ADD sort_index INTEGER UNSIGNED NOT NULL DEFAULT 0;

UPDATE part_type SET sort_index = 20 WHERE part_name != 'Quote' AND sort_index = 0;
UPDATE part_type SET sort_index = 5 WHERE part_name = 'Border';
UPDATE part_type SET sort_index = 15 WHERE part_name = 'Tassel';
UPDATE part_type SET sort_index = 20 WHERE part_name = 'Charm';
UPDATE part_type SET sort_index = 100 WHERE part_name = 'Personalization';

ALTER TABLE part_type ADD part_code VARCHAR(32);
UPDATE part_type SET part_code = 'tassel' WHERE part_id = 1;
UPDATE part_type SET part_code = 'ribbon' WHERE part_id = 2;
UPDATE part_type SET part_code = 'stamp' WHERE part_id = 3;
UPDATE part_type SET part_code = 'border' WHERE part_id = 4;
UPDATE part_type SET part_code = 'charm' WHERE part_id = 5;
UPDATE part_type SET part_code = 'quote' WHERE part_id = 6;
UPDATE part_type SET part_code = 'personalization' WHERE part_id = 7;
UPDATE part_type SET part_code = 'frame' WHERE part_id = 8;
UPDATE part_type SET part_code = 'domedglass' WHERE part_id = 9;
UPDATE part_type SET part_code = 'rectglass' WHERE part_id = 10;
UPDATE part_type SET part_code = 'pinback' WHERE part_id = 11;
UPDATE part_type SET part_code = 'image' WHERE part_id = 12;
UPDATE part_type SET part_code = 'handles' WHERE part_id = 13;
UPDATE part_type SET part_code = 'postaddress' WHERE part_id = 14;


###################################
ALTER TABLE productQuote ADD product_quote_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;


#################################
ALTER TABLE rec_quote DROP PRIMARY KEY;
ALTER TABLE rec_quote ADD rec_quote_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;


################################
DROP TABLE IF EXISTS product_sample_images;
CREATE TABLE IF NOT EXISTS product_sample_images
(
	product_image_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_type_id		INTEGER UNSIGNED,
	title			VARCHAR(255),
	description		VARCHAR(255)
);

###############################
DROP TABLE IF EXISTS product_testimonials;
CREATE TABLE IF NOT EXISTS product_testimonials
(
	product_testimonial_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_type_id         INTEGER UNSIGNED,
	testimonial_id		INTEGER UNSIGNED,
	sort_order	INTEGER UNSIGNED NOT NULL DEFAULT 0
);


##########################
DELETE FROM product_type where product_type_id = 0;
ALTER TABLE product_type DROP PRIMARY KEY;
ALTER TABLE product_type MODIFY COLUMN product_type_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;


#########################################
ALTER TABLE product_type ADD short_name VARCHAR(32);
UPDATE product_type SET short_name = name;
ALTER TABLE product_type CHANGE prod prod VARCHAR(32);

#####################################
ALTER TABLE product_sample_images ADD sort_index INTEGER UNSIGNED DEFAULT 0;
ALTER TABLE product_sample_images ADD INDEX (product_type_id, sort_index);
ALTER TABLE product_sample_images ADD file_ext VARCHAR(8);

######################
DROP TABLE IF EXISTS charm_categories;
CREATE TABLE IF NOT EXISTS charm_categories
(
	charm_category_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	category_name VARCHAR(64)
);

DROP TABLE IF EXISTS charm_category_charms;
CREATE TABLE IF NOT EXISTS charm_category_charms
(
	charm_category_charm_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	charm_category_id INTEGER UNSIGNED,
	charm_id INTEGER UNSIGNED
);

ALTER TABLE charm ADD charm_code VARCHAR(32);
 UPDATE charm SET charm_code =  REPLACE(REPLACE(graphic_location, "/charms/", ""), ".jpg", "");    

##########################################
DROP TABLE IF EXISTS specialty_pages;
CREATE TABLE IF NOT EXISTS specialty_pages
(
	specialty_page_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	page_url		VARCHAR(32), # URL, ie 'corporate'
	page_title		VARCHAR(255),
	body_title		VARCHAR(64),
	meta_keywords		VARCHAR(255),
	meta_desc		VARCHAR(255)
);

DROP TABLE IF EXISTS specialty_page_section_content;
CREATE TABLE IF NOT EXISTS specialty_page_section_content
(
	specialty_page_section_content_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	specialty_page_id		INTEGER UNSIGNED,
	page_section_name		VARCHAR(16), # intro, etc...
	content				TEXT
);

ALTER TABLE specialty_page_section_content ADD title VARCHAR(64);
ALTER TABLE specialty_pages ADD introduction TEXT;

##########################
DROP TABLE IF EXISTS specialty_page_sample_images;
CREATE TABLE IF NOT EXISTS specialty_page_sample_images
(
	specialty_page_image_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	specialty_page_id		INTEGER UNSIGNED,
	product_type_id			INTEGER UNSIGNED, # Can group by product.... showing dropdown, etc...
	title			VARCHAR(255),
	description		VARCHAR(255)
);
ALTER TABLE specialty_page_sample_images ADD sort_index INTEGER UNSIGNED DEFAULT 0;
ALTER TABLE specialty_page_sample_images ADD INDEX (specialty_page_id,sort_index);
ALTER TABLE specialty_page_sample_images ADD file_ext VARCHAR(8);

#######################################

DROP TABLE IF EXISTS specialty_page_testimonials;
CREATE TABLE IF NOT EXISTS specialty_page_testimonials
(
	specialty_page_testimonial_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	specialty_page_id         INTEGER UNSIGNED,
	testimonial_id		INTEGER UNSIGNED,
	sort_order	INTEGER UNSIGNED NOT NULL DEFAULT 0
);
###############

DROP TABLE IF EXISTS promo_pages;
CREATE TABLE IF NOT EXISTS promo_pages
(
	promo_page_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	page_title		VARCHAR(255),
	body_title		VARCHAR(64),
	meta_keywords		VARCHAR(255),
	meta_desc		VARCHAR(255)
);

DROP TABLE IF EXISTS promo_page_section_content;
CREATE TABLE IF NOT EXISTS promo_page_section_content
(
	promo_page_section_content_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	promo_page_id		INTEGER UNSIGNED,
	page_section_name		VARCHAR(16), # intro, etc...
	content				TEXT
);

DROP TABLE IF EXISTS promo_page_sample_images;
CREATE TABLE IF NOT EXISTS promo_page_sample_images
(
	promo_page_image_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	promo_page_id		INTEGER UNSIGNED,
	product_type_id			INTEGER UNSIGNED, # Can group by product.... showing dropdown, etc...
	title			VARCHAR(255),
	description		VARCHAR(255)
);

################################################
ALTER TABLE product_type ADD image_type SET('real','repro','custom') NOT NULL DEFAULT 'real,repro,custom';
UPDATE product_type SET image_type = 'real,repro,custom' WHERE stamp = 'Both';
UPDATE product_type SET image_type = 'real,custom' WHERE stamp = 'Real';
UPDATE product_type SET image_type = 'repro,custom' WHERE stamp = 'Repro';
UPDATE product_type SET image_type = 'custom' WHERE stamp = 'Custom';


################################################
# ADDING SUPPORT FOR wholesale/quantity pricing

ALTER TABLE customer ADD is_wholesale BOOL DEFAULT FALSE;
ALTER TABLE customer ADD pricing_level INTEGER UNSIGNED NOT NULL DEFAULT 1;

ALTER TABLE customer ADD is_admin BOOL DEFAULT false;
UPDATE customer SET is_admin = true WHERE EMail_address IN ('harmonydesigns@earthlink.net','webmaster@harmonydesigns.com','t_maly@comcast.net');

ALTER TABLE customer ADD reset_code VARCHAR(64);


ALTER TABLE product_type ADD wholesale_minimum INTEGER UNSIGNED NOT NULL DEFAULT 12;
################################################

UPDATE stamp SET thumbnail_location = REPLACE(thumbnail_location, ".jpg", ".gif"), image_location = REPLACE(image_location, ".jpg", ".gif");


##################################################
DROP TABLE IF EXISTS hdtasks;
CREATE TABLE IF NOT EXISTS hdtasks
(
	hdtask_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title		VARCHAR(64),
	summary		VARCHAR(255),

	priority	ENUM('back_burner','low','normal','medium','high','emergency') DEFAULT 'normal',
	status		ENUM('submitted','in_progress', 'code_complete','ready_for_testing','finished') DEFAULT 'submitted',
	due_date	DATETIME, # What is wanted
	expected_completion_date	DATETIME, # What I think.

	reference	TEXT, # urls, etc...
	description	TEXT # Details
);

###################################################
DROP TABLE IF EXISTS gallery_filter_keywords;
CREATE TABLE IF NOT EXISTS gallery_filter_keywords
(
	filter_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	path		VARCHAR(16), # url portion
	parent_url	VARCHAR(255), # where we came from to get here.... (ie specialty page)
	parent_title	VARCHAR(64), # specialty page, etc NAME
	name		VARCHAR(32),
	description	VARCHAR(255)
);

INSERT INTO gallery_filter_keywords SET path = "corporate", name = "Corporate";
INSERT INTO gallery_filter_keywords SET path = "education", name = "Education";
INSERT INTO gallery_filter_keywords SET path = "museum", name = "Museum Store";
INSERT INTO gallery_filter_keywords SET path = "wedding", name = "Wedding";

DROP TABLE IF EXISTS gallery_filters;
CREATE TABLE IF NOT EXISTS gallery_filters
(
	category_filter_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	filter_id	INTEGER UNSIGNED NOT NULL,
	browse_node_id	INTEGER UNSIGNED NOT NULL
);

#################################
ALTER TABLE part_type ADD part_title VARCHAR(255);
UPDATE part_type SET part_title = part_name;

ALTER TABLE part_type ADD is_step BOOL DEFAULT 1;
UPDATE part_type SET is_step = 0 where part_code = 'image';

INSERT INTO part_type SET part_name = 'Size', sort_index = 100, part_code = 'size', part_title = 'Size';
INSERT INTO part_type SET part_name = 'Print Side', sort_index = 100, part_code = 'printside', part_title = 'Print Side';


#####################################
ALTER TABLE product_type ADD quality_desc TEXT;

#######################################
ALTER TABLE shippingZoneCA ADD zoneID INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE shippingZoneInt ADD zoneID INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;

ALTER TABLE handlingCharge DROP PRIMARY KEY;
ALTER TABLE handlingCharge ADD handlingChargeID INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;

######################################
# BELOW IS OBSOLETE!
DROP TABLE IF EXISTS purchase_items;
CREATE TABLE IF NOT EXISTS purchase_items
(
	purchase_item_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	quantity INTEGER UNSIGNED,
	price DECIMAL(8,2) UNSIGNED,
	purchase_id INTEGER UNSIGNED NOT NULL, # Link to purchase table.
	product_type_id INTEGER UNSIGNED NOT NULL, # Which product
	specialID INTEGER UNSIGNED,
	reproduction ENUM('Yes','No'),
	comments TEXT,
	customization TEXT # XML
);
###################################
#######################
ALTER TABLE order_item ADD customization_xml TEXT;



###################################
DROP TABLE IF EXISTS tracking_requests;
CREATE TABLE IF NOT EXISTS tracking_requests
(
	tracking_request_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	customer_id INTEGER UNSIGNED,
	session_id VARCHAR(255),
	address VARCHAR(128),
	internal BOOL DEFAULT FALSE,
	browser VARCHAR(128),
	date DATETIME,
	complete_url VARCHAR(255),
	url VARCHAR(128),
	query_string VARCHAR(128),
	referer VARCHAR(128)
);

ALTER TABLE tracking_requests ADD INDEX (session_id), ADD INDEX (date), ADD INDEX (url);
ALTER TABLE tracking_requests ADD is_bot BOOL DEFAULT FALSE;
ALTER TABLE tracking_requests ADD referer_query_string VARCHAR(128), ADD complete_referer VARCHAR(255);
ALTER TABLE tracking_requests ADD INDEX (is_bot);
ALTER TABLE tracking_requests ADD INDEX (internal);
ALTER TABLE tracking_requests ADD INDEX (url);
ALTER TABLE tracking_requests ADD method VARCHAR(5);

#################################
DROP TABLE IF EXISTS tracking_visits;
CREATE TABLE IF NOT EXISTS tracking_visits
(
	tracking_visit_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	session_id VARCHAR(255),
	# CAN figure # of visits by grouping by session_id
	page_count INTEGER UNSIGNED NOT NULL DEFAULT 1, # How many 'hits'.
	session_start DATETIME,
	session_end DATETIME,
	referral_source VARCHAR(64),
	referer_query_string VARCHAR(255),
	INDEX (session_id)
);

ALTER TABLE tracking_visits ADD visit_count INTEGER UNSIGNED NOT NULL DEFAULT 1;
ALTER TABLE tracking_visits ADD customer_id INTEGER UNSIGNED;
ALTER TABLE tracking_visits ADD landingpage_url VARCHAR(255), ADD landingpage_query_string VARCHAR(255), ADD landingpage_complete_url VARCHAR(255);
ALTER TABLE tracking_visits ADD lastpage_url VARCHAR(255), ADD lastpage_query_string VARCHAR(255), ADD lastpage_complete_url VARCHAR(255);
#ALTER TABLE tracking_visits ADD landingpage_request_id INTEGER UNSIGNED, lastpage_request_id INTEGER UNSIGNED;
ALTER TABLE tracking_visits DROP INDEX session_id, ADD UNIQUE KEY (session_id);

# CONVERT existing records....
INSERT INTO tracking_visits (session_id) SELECT DISTINCT session_id FROM tracking_requests;

# start, refering info, landing info.
UPDATE tracking_visits s JOIN (
		SELECT r.* FROM tracking_requests r INNER JOIN (SELECT MIN(tracking_request_id) AS min_id FROM tracking_requests r GROUP BY session_id) AS ri ON r.tracking_request_id = ri.min_id
	) AS dr ON s.session_id = dr.session_id 
	SET s.session_start = dr.date, s.referral_source = dr.referer, s.referer_query_string = dr.referer_query_string, s.landingpage_url = dr.url, s.landingpage_complete_url = dr.complete_url, s.landingpage_query_string = dr.query_string;


# end of session, last page visited.
UPDATE tracking_visits s JOIN (
		SELECT r.* FROM tracking_requests r INNER JOIN (SELECT MAX(tracking_request_id) AS max_id FROM tracking_requests r GROUP BY session_id) AS ri ON r.tracking_request_id = ri.max_id
	) AS dr ON s.session_id = dr.session_id AND dr.session_id BETWEEN DATE_SUB(s.session_id, INTERVAL 30 MINUTE) AND s.session_id
	SET s.session_end = dr.date, s.lastpage_url = dr.url, s.lastpage_complete_url = dr.complete_url, s.lastpage_query_string = dr.query_string;


# customer tracking.
UPDATE tracking_visits s JOIN (SELECT r.session_id, r.customer_id FROM tracking_requests r WHERE r.customer_id IS NOT NULL GROUP BY r.customer_id) AS dr ON s.session_id = dr.session_id SET s.customer_id = dr.customer_id;

# page count
UPDATE tracking_visits s JOIN (SELECT session_id,COUNT(*) AS page_count FROM tracking_requests r GROUP BY r.session_id) AS dr ON s.session_id = dr.session_ID SET s.page_count = dr.page_count;

# SESSION LENGTH WILL BE ALL SCREWED UP!!!! Since cookies last for a long time.... cant really import unless we say


###################################
DROP TABLE IF EXISTS tracking_product_calculator_requests;
CREATE TABLE IF NOT EXISTS tracking_product_calculator_requests
(
	tracking_product_calculator_request_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	session_id VARCHAR(255),
	productCode VARCHAR(8),
	date DATETIME,
	quantity INTEGER UNSIGNED,
	options TEXT,
	INDEX (productCode)
);
ALTER TABLE tracking_product_calculator_requests ADD zipCode VARCHAR(8);
ALTER TABLE tracking_product_calculator_requests ADD minimum INTEGER UNSIGNED NOT NULL DEFAULT 1;


#################################
ALTER TABLE part_type ADD price FLOAT;
UPDATE part_type SET price = 1.00 WHERE part_name = 'Charm';
UPDATE product_part SET optional = 'yes' WHERE part_id = 5;
UPDATE part_type SET price = 0.50 WHERE part_name = 'Tassel';


ALTER TABLE part_type ADD is_feature BOOL DEFAULT true;
#UPDATE part_type SET part_title = "Tassel of your choice - FREE" where part_name = 'Tassel';
#UPDATE part_type SET part_title = "Ribbon of your choice - FREE" where part_name = 'Ribbon';
#UPDATE part_type SET part_title = "Mint-condition or licensed reproduction stamp" where part_name = 'Stamp';
#UPDATE part_type SET part_title = "Border of your choice - FREE" where part_name = 'Border';
#UPDATE part_type SET part_title = "Custom quote or text - FREE" where part_name = 'Quote';
#UPDATE part_type SET part_title = "Gold-plated charm" where part_name = 'Charm';
#UPDATE part_type SET part_title = "Personalization - FREE" where part_name = 'Personalization';
#UPDATE part_type SET part_title = "Frame of your choice - FREE" where part_name = 'Frame';
#UPDATE part_type SET part_title = "Custom image of your choice - FREE" where part_name = 'Image';
#UPDATE part_type SET part_title = "Handle color of your choice - FREE" where part_name = 'Handles';
#UPDATE part_type SET part_title = "Postcard address - FREE" where part_name = 'Postcard Address';
#UPDATE part_type SET part_title = "Multiple sizes of your choice - FREE" where part_name = 'Size';
#UPDATE part_type SET part_title = "Your choice print on front or back - FREE" where part_name = 'Print Side';

############################################
#DROP TABLE IF EXISTS pricing_discounts;
#CREATE TABLE IF NOT EXISTS pricing_discounts
#(
#	pricing_discount_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
#	product_type_id INTEGER UNSIGNED,
#	productCode VARCHAR(6),
#	quantity INTEGER UNSIGNED,
#	percent FLOAT # % off retail (single unit) pricing
#);

#################################
ALTER TABLE pricePoint ADD percent_discount DECIMAL(64,2);

# ONLY DO THIS AFTER NO LONGER NEED!!!!
# DELETE FROM pricePoint WHERE productCode = 'B' AND quantity = 12;

# 
ALTER TABLE product_type ADD base_price DECIMAL(64,2);
ALTER TABLE product_part CHANGE product_type_id product_type_id INTEGER UNSIGNED NOT NULL;
ALTER TABLE product_part DROP PRIMARY KEY;
ALTER TABLE product_part ADD product_part_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;

###################################
ALTER TABLE product_type ADD production_quantity_per_day INTEGER UNSIGNED DEFAULT 100;

# List of pages after a certain one....
CREATE VIEW tracking_prev_pages AS (SELECT r.url AS url, p.url AS prev_url, r.session_id AS session_id, r.date AS date, p.date AS prev_date FROM tracking_requests r LEFT JOIN tracking_requests p ON r.session_id = p.session_id AND p.date < r.date GROUP BY url);

CREATE VIEW tracking_next_pages AS (SELECT r.url AS url, n.url AS next_url, r.session_id AS session_id, r.date AS date, n.date AS next_date FROM tracking_requests r LEFT JOIN tracking_requests n ON r.session_id = n.session_id AND n.date > r.date GROUP BY url);


####################################
DROP TABLE IF EXISTS faqs;
CREATE TABLE IF NOT EXISTS faqs
(
	faq_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	faq_topic_id INTEGER UNSIGNED,
	product_type_id INTEGER UNSIGNED,
	part_id INTEGER UNSIGNED,
	enabled BOOL DEFAULT TRUE,
	question VARCHAR(128),
	answer TEXT
);

DROP TABLE IF EXISTS faq_topics;
CREATE TABLE IF NOT EXISTS faq_topics
(
	faq_topic_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	topic_name VARCHAR(32),
	global_enabled BOOL DEFAULT TRUE # Whether to show up in 'global' faq list...
);
ALTER TABLE faq_topics ADD product_enabled BOOL DEFAULT FALSE; # Whether enable for product details 'common questions' tab.

INSERT INTO faq_topics SET topic_name = 'All Products';
INSERT INTO faq_topics SET topic_name = 'Specific Products';
INSERT INTO faq_topics SET topic_name = 'Custom Products';
INSERT INTO faq_topics SET topic_name = 'Wholesale';

################################
DROP TABLE IF EXISTS content_snippets;
CREATE TABLE IF NOT EXISTS content_snippets
(
	content_snippet_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	snippet_code VARCHAR(24), # How to reference!
	snippet_title VARCHAR(64),
	content TEXT
);

################################
DROP TABLE IF EXISTS cart_items;
CREATE TABLE IF NOT EXISTS cart_items
(
	cart_item_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	customer_id INTEGER UNSIGNED, # 'save' for later will assign here....
	quantity INTEGER UNSIGNED NOT NULL DEFAULT 1,
	session_id VARCHAR(255),
	productCode VARCHAR(16),
	unitPrice DECIMAL(16,2),
	parts BLOB
);

###################################
ALTER TABLE countries DROP primary key;
ALTER TABLE countries ADD country_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;


###################################
ALTER TABLE purchase ADD Charge_Amount DECIMAL(5,2) UNSIGNED;

##################################
ALTER TABLE cart_items ADD comments VARCHAR(255);
ALTER TABLE item_parts ADD purchase_ID INTEGER UNSIGNED;


#################################
ALTER TABLE contact_info ADD is_po_box BOOL DEFAULT FALSE;

################################
ALTER TABLE purchase ADD ships_by DATETIME;

################################
ALTER TABLE stamp_surcharge DROP PRIMARY KEY;
ALTER TABLE stamp_surcharge ADD stamp_surcharge_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;

################################
ALTER TABLE contact_info ADD Company VARCHAR(100);

################################
CREATE TABLE partPricePoint (
  part_price_point_id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  part_code VARCHAR(6) NOT NULL default '',
  quantity int(10) unsigned NOT NULL default '0',
  price decimal(5,2) unsigned NOT NULL default '0.00',
  part_type_id int(10) unsigned default NULL
);

################################
ALTER TABLE customer DROP KEY idHash;


##################################
ALTER TABLE shippingPricePoint ADD cost_old DECIMAL(5,2) UNSIGNED;            
UPDATE shippingPricePoint SET cost_old = cost;


####################################
UPDATE part_type SET sort_index = 0, part_name = 'Stamp Type' WHERE part_code = 'stamp';
UPDATE part_type SET sort_index = 1 WHERE part_code = 'quote';


###########################
UPDATE part_type SET part_name = 'Quotation/Text' where part_name = 'Quote';

#######################
UPDATE part_type SET part_title = '';

#######################
INSERT INTO product_part SET product_type_id = '1' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '2' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '3' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '4' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '5' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '6' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '7' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '8' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '11' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '12' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '13' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '14' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '15' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '17' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '19' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '24' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '27' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');
INSERT INTO product_part SET product_type_id = '33' , optional = 'no', sort_index = 0, part_id = (SELECT part_id from part_type WHERE part_code = 'stamp');

######################

DROP TABLE IF EXISTS clients;
CREATE TABLE IF NOT EXISTS clients
(
	client_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	company VARCHAR(128),
	name VARCHAR(64),
	comments TEXT
);

##########################
UPDATE shippingMethod SET dayMin = 2 WHERE name = 'FedEx Ground';


##########################
DROP TABLE IF EXISTS product_categories;
CREATE TABLE IF NOT EXISTS product_categories
(
	product_category_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(64)
);

INSERT INTO product_categories SET name = 'Custom Products';
INSERT INTO product_categories SET name = 'For Crafters';
INSERT INTO product_categories SET name = 'Ready Made';

ALTER TABLE product_type ADD product_category_id INTEGER UNSIGNED;
UPDATE product_type SET product_category_id = (SELECT product_category_id FROM product_categories WHERE name LIKE '%Custom%');

ALTER TABLE product_categories ADD sort_index INTEGER UNSIGNED;
UPDATE product_categories SET sort_index = 10 WHERE name = 'Custom Products';
UPDATE product_categories SET sort_index = 20 WHERE name = 'For Crafters';
UPDATE product_categories SET sort_index = 30 WHERE name = 'Ready Made';

#########################
ALTER TABLE part_type CHANGE sort_index sort_index INTEGER UNSIGNED NOT NULL DEFAULT 100;

#########################
ALTER TABLE frame ADD sort_index INTEGER UNSIGNED DEFAULT 100;
UPDATE frame SET sort_index = 10 WHERE name = 'rosewood';
UPDATE frame SET sort_index = 20 WHERE name = 'walnut';
UPDATE frame SET sort_index = 30 WHERE name = 'natural';

#########################
DROP TABLE IF EXISTS static_pages;
CREATE TABLE IF NOT EXISTS static_pages
(
	static_page_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	path VARCHAR(255),
	meta_keywords VARCHAR(255),
	meta_desc VARCHAR(255),
	page_title VARCHAR(128),
	body_title VARCHAR(128),
	content TEXT
);

#########################
ALTER TABLE part_type ADD part_summary VARCHAR(255);

######################
ALTER TABLE cart_items ADD created DATETIME, ADD modified DATETIME;


#################
ALTER TABLE testimonial ADD sort_index INTEGER UNSIGNED DEFAULT 0;
UPDATE testimonial SET sort_index = testimonial_id;


###################
UPDATE countries SET can_order = 'No' WHERE iso_code NOT IN ('CA','EN','WL','US','IE','NB');


#####################
ALTER TABLE stamp_surcharge ADD stamp_id INTEGER UNSIGNED;
UPDATE stamp_surcharge, stamp SET stamp_surcharge.stamp_id = stamp.stampID WHERE stamp_surcharge.catalog_number = stamp.catalog_number;


#####################
ALTER TABLE browse_node ADD thumb_catalog_number VARCHAR(30);

#####################
DROP TABLE IF EXISTS product_quotes;
CREATE TABLE IF NOT EXISTS product_quotes
(
	product_quote_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_type_id		INTEGER UNSIGNED,
	quote_id		INTEGER UNSIGNED
);

####################
DROP TABLE IF EXISTS configs;
CREATE TABLE IF NOT EXISTS configs
(
	config_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name		VARCHAR(16),
	value		VARCHAR(255)
);

#################
ALTER TABLE quote CHANGE attribution attribution VARCHAR(255) NOT NULL DEFAULT "";
UPDATE quote SET attribution = "" WHERE attribution IS NULL;


#######################
ALTER TABLE product_type ADD product_template SET('imageonly','textonly'); # OTHER than default!

#######################
ALTER TABLE custom_image ADD raw_location VARCHAR(255);


#######################
DROP TABLE IF EXISTS work_requests;
CREATE TABLE IF NOT EXISTS work_requests
(
	work_request_id	INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	email VARCHAR(255),
	phone VARCHAR(30),
	product_type_id INTEGER UNSIGNED,
	quantity INTEGER UNSIGNED,
	image_location VARCHAR(255),
	credit_card_id INTEGER UNSIGNED,
	billing_id INTEGER UNSIGNED,
	shipping_id INTEGER UNSIGNED,
	proof_only BOOL DEFAULT FALSE,
	pre_production BOOL DEFAULT FALSE,
	random_sample BOOL DEFAULT FALSE,
	comments TEXT
);

#############################
ALTER TABLE order_item ADD proof ENUM('no','yes','only') DEFAULT 'no';
ALTER TABLE cart_items ADD proof ENUM('no','yes','only') DEFAULT 'no';


##############################
ALTER TABLE work_requests ADD paypal BOOL DEFAULT FALSE;

##############################
ALTER TABLE purchase CHANGE Charge_Amount Charge_Amount DECIMAL(10,2);

##############################
ALTER TABLE specialty_pages ADD subjects VARCHAR(255);

DROP TABLE IF EXISTS specialty_page_clients;
CREATE TABLE IF NOT EXISTS specialty_page_clients
(
	specialty_page_client_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	specialty_page_id INTEGER UNSIGNED,
	client_id INTEGER UNSIGNED
);

##############################
ALTER TABLE work_requests ADD wholesale BOOL DEFAULT false;

#############################
ALTER TABLE testimonial ADD customer_type_id INTEGER UNSIGNED;
ALTER TABLE testimonial ADD approved BOOL DEFAULT FALSE;
UPDATE testimonial SET approved = 1;

DROP TABLE IF EXISTS customer_types;
CREATE TABLE IF NOT EXISTS customer_types
(
	customer_type_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(100)
);

DROP TABLE IF EXISTS customer_ratings;
CREATE TABLE IF NOT EXISTS customer_ratings
(
	customer_rating_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(100),
	organization VARCHAR(100),
	email VARCHAR(100), # optional
	
	product_rating INTEGER UNSIGNED,
	service_rating INTEGER UNSIGNED,
	customer_type_id INTEGER UNSIGNED, # who they are... for categorization
	permission BOOL DEFAULT FALSE # Can reuse publically

);

DROP TABLE IF EXISTS product_customer_ratings;
CREATE TABLE IF NOT EXISTS product_customer_ratings
(
	product_customer_rating_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_type_id INTEGER UNSIGNED NOT NULL,
	customer_rating_id INTEGER UNSIGNED NOT NULL
);

#########################################
DROP TABLE IF EXISTS tracking_areas;
CREATE TABLE IF NOT EXISTS tracking_areas # Sections, ie 'custom_images', etc...
(
	tracking_area_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(32),
	url VARCHAR(64), # url location, ie controller
	description TEXT
);

DROP TABLE IF EXISTS tracking_tasks;
CREATE TABLE IF NOT EXISTS tracking_tasks # list, upload, etc...
(
	tracking_task_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	tracking_area_id INTEGER UNSIGNED,
	name VARCHAR(32),
	url VARCHAR(64), # ie controller action
	description TEXT
);

DROP TABLE IF EXISTS tracking_entries;
CREATE TABLE IF NOT EXISTS tracking_entries # actual calls.
(
	tracking_entry_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	tracking_area_id INTEGER UNSIGNED,
	tracking_task_id INTEGER UNSIGNED,
	tracking_release_id INTEGER UNSIGNED,
	# Would we place tracking_release_id HERE? (would make things easier! so entries automatically tied to release!)
	# Tho we need to consider 'latest' release for given area
	tracking_visit_id INTEGER UNSIGNED,
	# do we need to track differing 'sessions'? (ie what group of tasks were done relatively together versus days/etc apart)
	session_id VARCHAR(255), # just in case, for whatever reason. (cookie)
	# Do we need to track session_id ? 

	referer VARCHAR(255),
	referer_qs VARCHAR(255),
	# NEED TO TRACK WHERE CAME FROM!!!! (referer) - does that need to be filtered?

	created DATETIME
);
ALTER TABLE tracking_entries ADD ip_address VARCHAR(16);


DROP TABLE IF EXISTS tracking_releases; # Marked
CREATE TABLE IF NOT EXISTS tracking_releases
(
	tracking_release_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	description TEXT,
	created DATETIME
);
# FIRST RELEASE needs to include ALL areas....


# Can assign multiple areas changed in a release
DROP TABLE IF EXISTS tracking_release_tracking_areas;
CREATE TABLE IF NOT EXISTS tracking_release_tracking_areas
(
	tracking_release_tracking_area_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	tracking_release_id INTEGER UNSIGNED,
	tracking_area_id INTEGER UNSIGNED
);

#####################################
ALTER TABLE cart_items ADD template VARCHAR(16) NOT NULL DEFAULT 'standard';
ALTER TABLE order_item ADD template VARCHAR(16) NOT NULL DEFAULT 'standard';

#######################################
ALTER TABLE tracking_entries ADD customer_id INTEGER UNSIGNED;

#######################################
DROP TABLE IF EXISTS tracking_processes;
CREATE TABLE IF NOT EXISTS tracking_processes
(
	tracking_process_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	tracking_area_id INTEGER UNSIGNED, # Section belongs to. ???
	tracking_task_id INTEGER UNSIGNED, # What 'task' to start with.
	name VARCHAR(16),
	description TEXT
);

DROP TABLE IF EXISTS tracking_task_steps;
CREATE TABLE IF NOT EXISTS tracking_task_steps
(
	tracking_task_step_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	tracking_process_id INTEGER UNSIGNED,
	tracking_task_id INTEGER UNSIGNED,
	tracking_next_task_id INTEGER UNSIGNED
);

###################################
ALTER TABLE tracking_entries ADD complete BOOL DEFAULT FALSE;
ALTER TABLE tracking_tasks ADD sort_index INTEGER UNSIGNED;


##############################
ALTER TABLE item_parts ADD imageCrop VARCHAR(20), ADD template VARCHAR(16) DEFAULT 'standard';


#############################
ALTER TABLE product_type ADD image_only BOOL DEFAULT TRUE;

#############################
ALTER TABLE configs CHANGE name name VARCHAR(64);

#############################
ALTER TABLE purchase ADD free_shipping BOOL DEFAULT false;


#############################
DROP TABLE IF EXISTS purchase_steps;
CREATE TABLE IF NOT EXISTS purchase_steps
(
	purchase_step_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(32), # key - product, image, cart, options, layout, etc...
	title VARCHAR(32), # what shows up on the screen, someday?
	text VARCHAR(32) # generic text that shows up....
);

INSERT INTO purchase_steps SET name = 'product', title ='select product';
INSERT INTO purchase_steps SET name = 'image', title ='select image';
INSERT INTO purchase_steps SET name = 'layout', title ='select layout',text='(for custom images only)';
INSERT INTO purchase_steps SET name = 'options', title ='select order options';
INSERT INTO purchase_steps SET name = 'cart', title ='add to cart';

##################################
ALTER TABLE product_type ADD choose_index INTEGER UNSIGNED NOT NULL DEFAULT 1;
UPDATE product_type SET choose_index = 10 WHERE code = 'B';
UPDATE product_type SET choose_index = 20 WHERE code = 'BC';

#####################################
ALTER TABLE work_requests ADD created DATETIME, ADD modified DATETIME;

####################################
ALTER TABLE purchase ADD Old_Shipping_Cost DECIMAL(5,2) UNSIGNED;


#######################################
DROP INDEX Username ON customer;


#######################################
ALTER TABLE cart_items CHANGE comments comments TEXT;


##########################################
ALTER TABLE work_requests CHANGE proof_only proof_only INTEGER;

#########################################
ALTER TABLE product_type ADD build_notes TEXT;

#########################################
ALTER TABLE product_type ADD pricing_description VARCHAR(255);

########################################
ALTER TABLE item_parts ADD crystalType VARCHAR(24);

########################################
ALTER TABLE purchase ADD session_id VARCHAR(255);

########################################
ALTER TABLE tracking_requests CHANGE referer_query_string referer_query_string VARCHAR(255);


#########################################
ALTER TABLE purchase CHANGE Credit_Card_ID Credit_Card_ID INTEGER;
ALTER TABLE customer ADD billme BOOL DEFAULT FALSE;
ALTER TABLE purchase ADD customer_po VARCHAR(255);


########################################
DROP TABLE IF EXISTS saved_items;
CREATE TABLE IF NOT EXISTS saved_items
(
	saved_item_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	customer_id INTEGER UNSIGNED,
	name VARCHAR(255),
	build_data TEXT,
	created DATETIME,
	modified DATETIME
);

#ALTER TABLE saved_items ADD productCode VARCHAR(16), ADD catalog_number VARCHAR(32), ADD image_id INTEGER UNSIGNED;

########################################
DROP TABLE IF EXISTS product_options;
CREATE TABLE IF NOT EXISTS product_options
(
	product_option_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_type_id INTEGER UNSIGNED,
	option_name VARCHAR(128),
	option_description TEXT
);

DROP TABLE IF EXISTS product_features;
CREATE TABLE IF NOT EXISTS product_features
(
	product_feature_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_type_id INTEGER UNSIGNED,
	product_option_id INTEGER UNSIGNED
);
ALTER TABLE product_features ADD included BOOL DEFAULT FALSE, ADD text VARCHAR(128);

#########################################
ALTER TABLE item_parts ADD centerQuote BOOL DEFAULT FALSE;
ALTER TABLE product_options ADD sort_index INTEGER UNSIGNED NOT NULL DEFAULT 0;

###########################################
ALTER TABLE item_parts CHANGE Size Size VARCHAR(128);

##########################################
ALTER TABLE specialty_pages ADD subjects TEXT;

##########################################
ALTER TABLE specialty_pages ADD sort_index INTEGER UNSIGNED DEFAULT 0;

###########################################
ALTER TABLE specialty_pages ADD link_name VARCHAR(24);

###########################################
ALTER TABLE specialty_pages ADD enabled BOOL DEFAULT FALSE;

###########################################
DROP TABLE IF EXISTS specialty_page_prospects;
CREATE TABLE IF NOT EXISTS specialty_page_prospects
(
	specialty_page_prospects_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	specialty_page_id INTEGER UNSIGNED,
	name VARCHAR(64),
	organization VARCHAR(64),
	email VARCHAR(128),
	phone VARCHAR(24),
	address1 VARCHAR(64),
	address2 VARCHAR(64),
	city VARCHAR(64),
	state VARCHAR(64),
	zipcode VARCHAR(10),

	sample1 VARCHAR(10),
	sample2 VARCHAR(10),
	sample3 VARCHAR(10),

	project_details TEXT,

	want_quote BOOL DEFAULT FALSE,
	want_catalog BOOL DEFAULT FALSE,
	want_consultation BOOL DEFAULT FALSE,
	want_sample BOOL DEFAULT FALSE,
	created DATETIME
);
#############################
ALTER TABLE product_type ADD fullbleed BOOL DEFAULT TRUE;
############################
ALTER TABLE product_type CHANGE fullbleed fullbleed BOOL DEFAULT FALSE;
UPDATE product_type SET fullbleed = 0 WHERE code NOT IN ('B','BNT','BNC','DPW','DPW-FLC');

#############################
ALTER TABLE custom_image ADD orient INTEGER UNSIGNED DEFAULT 0;
#############################
ALTER TABLE item_parts ADD fullbleed BOOL DEFAULT FALSE;

####################################
DROP TABLE IF EXISTS email_templates;
CREATE TABLE IF NOT EXISTS email_templates
(
	email_template_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(16),
	message TEXT # Generic part of message that goes with it. (body is elsewhere in template)
);
ALTER TABLE email_templates ADD subject VARCHAR(255);


DROP TABLE IF EXISTS email_messages;
CREATE TABLE IF NOT EXISTS email_messages
(
	email_message_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email_template_id INTEGER UNSIGNED,
	catalog_number VARCHAR(16),
	image_id INTEGER UNSIGNED,
	customQuote TEXT,
	personalizationInput VARCHAR(255),
	border_id INTEGER UNSIGNED,
	charm_id INTEGER UNSIGNED,
	tassel_id INTEGER UNSIGNED,
	ribbon_id INTEGER UNSIGNED,
	layout ENUM('standard','imageonly','fullbleed'),
	custom_message TEXT
);
ALTER TABLE email_messages ADD subject VARCHAR(255);
ALTER TABLE email_messages CHANGE layout template ENUM('standard','imageonly','fullbleed');
ALTER TABLE email_messages ADD created DATETIME, ADD modified DATETIME;
ALTER TABLE email_messages ADD recipients TEXT; # newline separated email list, etc.


DROP TABLE IF EXISTS email_message_recipients;
CREATE TABLE IF NOT EXISTS email_message_recipients
(
	email_message_recipient_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email_message_id INTEGER UNSIGNED,
	customer_id INTEGER UNSIGNED,
	email VARCHAR(128)
);

###############################################
ALTER TABLE product_type ADD free_with_your_order TEXT;

###############################################
ALTER TABLE product_type ADD imageonly BOOL DEFAULT TRUE;

##############################################
DROP TABLE IF EXISTS email_letters;
CREATE TABLE IF NOT EXISTS email_letters
(
	email_letter_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	letter_name VARCHAR(64),
	email_template_id INTEGER UNSIGNED,
	subject VARCHAR(255),
	catalog_number VARCHAR(16),
	image_id INTEGER UNSIGNED,
	customQuote TEXT,
	personalizationInput VARCHAR(255),
	border_id INTEGER UNSIGNED,
	charm_id INTEGER UNSIGNED,
	tassel_id INTEGER UNSIGNED,
	ribbon_id INTEGER UNSIGNED,
	layout ENUM('standard','imageonly','fullbleed'),
	custom_message TEXT
);
ALTER TABLE email_letters CHANGE layout template ENUM('standard','imageonly','fullbleed');


#############################################
DROP TABLE IF EXISTS tips;
CREATE TABLE IF NOT EXISTS tips
(
	tip_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	tip_code VARCHAR(24),
	title VARCHAR(32),
	content TEXT
);

#############################################
ALTER TABLE email_messages ADD create_account ENUM('','retail','wholesale');
ALTER TABLE email_messages ADD allow_billme BOOL DEFAULT FALSE;
ALTER TABLE email_messages ADD account_password VARCHAR(64);
ALTER TABLE customer ADD session_id VARCHAR(255);

################################################
ALTER TABLE customer ADD created DATETIME, ADD modified DATETIME;


##################################################
ALTER TABLE product_type ADD rush_quantity_per_day INTEGER UNSIGNED;
UPDATE product_type SET rush_quantity_per_day = production_quantity_per_day * 2;
ALTER TABLE product_type ADD rush_cost_percentage INTEGER UNSIGNED;
UPDATE product_type SET rush_cost_percentage = 100;

##################################################
ALTER TABLE purchase ADD rush_date DATE;
ALTER TABLE purchase ADD rush_cost DECIMAL(5,2) UNSIGNED;
ALTER TABLE purchase CHANGE rush_cost rush_cost FLOAT UNSIGNED;


###################################################
UPDATE shippingMethod SET available = 'no' WHERE shippingMethodID IN (6,5);

###################################################
UPDATE countries SET can_order = 'Yes' WHERE iso_code = 'AU';

#####################################################
UPDATE shippingMethod SET name = 'Express Mail International (USPS)', dayMin = 3, dayMax = 5 WHERE shippingMethodID = 10;

#####################################################
INSERT INTO shippingMethod SET shippingMethodID = 11, name ='Priority Mail International (USPS)',type='expedited',available='yes',dayMin=1,dayMax=3;
UPDATE shippingMethod set dayMin = 6, dayMax = 10 WHERE shippingMethodID = 11;

#
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('AU',30,11);
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('EN',25,11);
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('WL',25,11);
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('IE',25,11);
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('NB',25,11);
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('CA',21,11);
# data in pmi.sql

# Update express intl
DELETE FROM shippingZoneInt WHERE shippingMethod = 10;

INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('AU',30,10);
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('EN',25,10);
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('WL',25,10);
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('IE',25,10);
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('NB',25,10);
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES ('CA',21,10);

# data in emi.sql

#############################
ALTER TABLE product_type ADD wholesale_info TEXT;

##############################
ALTER TABLE customer ADD myob_record_id INTEGER UNSIGNED;

############################
ALTER TABLE purchase ADD invoice_id INTEGER UNSIGNED;
ALTER TABLE order_item ADD description TEXT; # For imports w/o parts details.
ALTER TABLE order_item ADD item_code VARCHAR(255);

############################
ALTER TABLE configs ADD description TEXT;
############################
ALTER TABLE customer ADD customer_type VARCHAR(6);

##########################
UPDATE shippingMethod set dayMax = 5, available = 'yes' where shippingMethodID = 6;

##########################
ALTER TABLE item_parts ADD personalizationColor VARCHAR(12);
ALTER TABLE item_parts CHANGE centerText centerQuote BOOL;


###########################
ALTER TABLE purchase CHANGE Order_Date Order_Date DATETIME; # Record exact time done, so diagnose duplicates, etc.


###########################
ALTER TABLE clients add sort_index INTEGER UNSIGNED DEFAULT 0;
UPDATE clients set sort_index = client_id * 10;


############################
ALTER TABLE cart_items ADD rotate INTEGER;
ALTER TABLE order_item ADD rotate INTEGER;

############################
ALTER TABLE product_type ADD image_and_text BOOL DEFAULT TRUE;

########################
# hide smkc, bnt, bc from initial preview list (let them select on build page)
update product_type set buildable = 'No'  where product_type_id IN (15,35,2);

################
update countries set can_order = 'yes' where iso_code = 'VI';
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES('VI',9,6); # Priority USPS (domestic)
INSERT INTO shippingZoneInt (country,zone,shippingMethod) VALUES('VI',9,7); # Express USPS (domestic)

################
CREATE INDEX yearweek_referer ON tracking_requests (date, url, referer);
CREATE INDEX date_url ON tracking_requests (date, url);

################
UPDATE shippingMethod SET available = 'no' WHERE name = 'Express Mail (USPS)';

#################
DROP TABLE IF EXISTS sample_requests;
CREATE TABLE IF NOT EXISTS sample_requests
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_type_id INTEGER UNSIGNED,
	name VARCHAR(64),
	organization VARCHAR(64),
	address_1 VARCHAR(128),
	address_2 VARCHAR(128),
	city VARCHAR(32),
	state VARCHAR(32),
	zip_code VARCHAR(8),

	email VARCHAR(128),
	phone VARCHAR(32),

	comments TEXT,

	created DATETIME,
	modified DATETIME
);

############
DROP TABLE IF EXISTS quote_requests;
CREATE TABLE IF NOT EXISTS quote_requests
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_id INTEGER UNSIGNED,
	quantity INTEGER UNSIGNED,
	options VARCHAR(255), # csv of extra paid options

	comments TEXT,

	name VARCHAR(64),
	organization VARCHAR(64),
	email VARCHAR(128),
	phone VARCHAR(32),

	created DATETIME,
	modified DATETIME

);

#######################################
ALTER TABLE product_type ADD free_sample BOOL DEFAULT TRUE;

################################
DROP TABLE IF EXISTS template_requests;
CREATE TABLE IF NOT EXISTS template_requests
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_id INTEGER UNSIGNED,

	comments TEXT,

	name VARCHAR(64),
	organization VARCHAR(64),
	email VARCHAR(128),
	phone VARCHAR(32),

	created DATETIME,
	modified DATETIME

);

######################################
DROP TABLE IF EXISTS tracking_links;
CREATE TABLE IF NOT EXISTS tracking_links
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	referer VARCHAR(128), # Landing page.
	url VARCHAR(128), # Link
	name VARCHAR(128), # Label
	x INTEGER UNSIGNED, # mouse click x
	y INTEGER UNSIGNED,

	session_id VARCHAR(255),
	ip_address VARCHAR(24),

	created DATETIME,
	modified DATETIME
);

ALTER TABLE tracking_links ADD section VARCHAR(12); # product, build, etc.
ALTER TABLE tracking_links ADD product_type_id INTEGER UNSIGNED;
ALTER TABLE tracking_links ADD template VARCHAR(12);
ALTER TABLE tracking_links ADD INDEX section(section);


########################################
ALTER TABLE faq_topics ADD enabled BOOL DEFAULT FALSE;
ALTER TABLE faqs ADD sort_index INTEGER UNSIGNED;
ALTER TABLE faq_topics ADD sort_index INTEGER UNSIGNED;

##########################################
CREATE TABLE `completed_art_images` (
  `id` INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `product_id` INTEGER UNSIGNED,
  `name` VARCHAR(64),
  `email` VARCHAR(128),
  `phone` VARCHAR(32),
  `organization` VARCHAR(64),
  `comments` TEXT,
  `original_path` VARCHAR(255),
  `display_path` VARCHAR(255),
  `thumb_path` VARCHAR(255),
  `created` DATETIME,
  `modified` DATETIME
);


##################################
DROP TABLE IF EXISTS faq_requests;
CREATE TABLE IF NOT EXISTS faq_requests
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

	name VARCHAR(24),
	organization VARCHAR(32),
	email VARCHAR(36),
	phone VARCHAR(16),

	faq_topic_id INTEGER UNSIGNED,

	question TEXT,

	replied BOOL DEFAULT FALSE,

	created DATETIME,
	modified DATETIME
);

#################################
ALTER TABLE tracking_visits ADD referer_search VARCHAR(255);
ALTER TABLE tracking_visits ADD address VARCHAR(20);

ALTER TABLE tracking_visits ADD did_upload BOOL DEFAULT FALSE;
ALTER TABLE tracking_visits ADD did_build BOOL DEFAULT FALSE;
ALTER TABLE tracking_visits ADD did_cart BOOL DEFAULT FALSE;
ALTER TABLE tracking_visits ADD did_checkout BOOL DEFAULT FALSE;
ALTER TABLE tracking_visits ADD did_order BOOL DEFAULT FALSE;

##################################
ALTER TABLE product_type ADD made_in_usa_text TEXT;

###################################
ALTER TABLE product_type ADD customizable BOOL DEFAULT FALSE;

ALTER TABLE product_type ADD setup_charge FLOAT UNSIGNED;

ALTER TABLE cart_items ADD setupPrice DECIMAL(16,2);
ALTER TABLE order_item ADD setupPrice DECIMAL(16,2);

##################################
DROP TABLE IF EXISTS page_emails;
CREATE TABLE IF NOT EXISTS page_emails
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

	your_name VARCHAR(64),
	recipient VARCHAR(128),
	subject VARCHAR(128),
	url VARCHAR(255),
	custom_message TEXT,

	created DATETIME,
	modified DATETIME
);

alter table completed_art_images ADD quantity INTEGER UNSIGNED;
ALTER TABLE product_type ADD textonly BOOL DEFAULT FALSE;

ALTER TABLE customer ADD guest BOOL DEFAULT FALSE;

ALTER TABLE completed_art_images ADD price_quote BOOL DEFAULT FALSE;

CREATE TABLE IF NOT EXISTS build_emails
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

	your_name VARCHAR(64),
	recipient VARCHAR(128),
	subject VARCHAR(128),
	custom_message TEXT,

	build_data BLOB,
	created DATETIME,
	modified DATETIME
);

ALTER TABLE item_parts ADD alignQuote VARCHAR(10);

ALTER TABLE item_parts ADD personalization_logo_id INTEGER UNSIGNED;
ALTER TABLE item_parts ADD customized BOOL DEFAULT FALSE;

ALTER TABLE product_type CHANGE customizable customizable ENUM('','text','logo','both');

#################################################
CREATE TABLE IF NOT EXISTS update_comments
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

	date DATE, # Effective week.

	comments TEXT,

	created DATETIME,
	modified DATETIME
);

###################################
CREATE FULLTEXT INDEX search ON stamp (keywords, stamp_name, series, catalog_number);
CREATE FULLTEXT INDEX search ON product_type (name,pricing_name,meta_keywords,meta_desc,main_intro,description);
CREATE FULLTEXT INDEX name ON product_type (name,pricing_name);
CREATE FULLTEXT INDEX description ON product_type (meta_keywords,meta_desc,main_intro,description);

##################################
INSERT INTO searchProductWord set word = 'gifts';
INSERT INTO searchProductWord set word = 'custom';
INSERT INTO searchProductWord set word = 'personalized';


########################################
DELETE FROM shippingPricePoint WHERE weight > 65;


##########################################
ALTER TABLE product_type ADD semi_customizable BOOL DEFAULT FALSE;
ALTER TABLE product_type ADD semi_customizable_catalog_number VARCHAR(16);
ALTER TABLE product_type ADD semi_customizable_quotes TEXT;

##########################################
ALTER TABLE product_type ADD blank_product_type_id INTEGER UNSIGNED;

########################################
#DROP TABLE IF EXISTS wholesale_account_requests;
CREATE TABLE IF NOT EXISTS wholesale_account_requests
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

	name VARCHAR(32),
	organization VARCHAR(48),
	email VARCHAR(64),
	phone VARCHAR(24),
	reseller_number VARCHAR(24),
	
	created DATETIME,
	modified DATETIME
);

# 
ALTER TABLE customer ADD reseller_number VARCHAR(24);



##########################

CREATE TABLE sample_request_product_types
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

	sample_request_id INTEGER UNSIGNED,
	product_type_id INTEGER UNSIGNED,

	created DATETIME,
	modified DATETIME
);


##########################
ALTER TABLE rec_ribbon DROP PRIMARY KEY, ADD id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE rec_tassel DROP PRIMARY KEY, ADD id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE rec_charm DROP PRIMARY KEY, ADD id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE rec_border DROP PRIMARY KEY, ADD id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;

###############################
ALTER TABLE rec_ribbon ADD stamp_id INTEGER UNSIGNED;
ALTER TABLE rec_tassel ADD stamp_id INTEGER UNSIGNED;
ALTER TABLE rec_charm ADD stamp_id INTEGER UNSIGNED;
ALTER TABLE rec_border ADD stamp_id INTEGER UNSIGNED;
ALTER TABLE rec_quote ADD stamp_id INTEGER UNSIGNED;
UPDATE rec_ribbon,stamp SET rec_ribbon.stamp_id = stamp.stampID WHERE rec_ribbon.Catalog_Number = stamp.catalog_number;
UPDATE rec_tassel,stamp SET rec_tassel.stamp_id = stamp.stampID WHERE rec_tassel.Catalog_Number = stamp.catalog_number;
UPDATE rec_charm,stamp SET rec_charm.stamp_id = stamp.stampID WHERE rec_charm.Catalog_Number = stamp.catalog_number;
UPDATE rec_border,stamp SET rec_border.stamp_id = stamp.stampID WHERE rec_border.Catalog_Number = stamp.catalog_number;
UPDATE rec_quote,stamp SET rec_quote.stamp_id = stamp.stampID WHERE rec_quote.Catalog_Number = stamp.catalog_number;
#####################
ALTER TABLE browse_link ADD stamp_id INTEGER UNSIGNED;
UPDATE browse_link,stamp set browse_link.stamp_id = stamp.stampID WHERE browse_link.catalog_number = stamp.catalog_number;


#######################################################
# July 21 2011

#DROP TABLE IF EXISTS contact_requests;
CREATE TABLE IF NOT EXISTS contact_requests
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(64),
	phone VARCHAR(24),
	email VARCHAR(64),
	message TEXT,
	created DATETIME,
	modified DATETIME
);

#####################################################3
# Sep 13 2011
ALTER TABLE customer ADD profile_id INTEGER UNSIGNED, ADD payment_profile_id INTEGER UNSIGNED;
ALTER TABLE purchase ADD profile_id INTEGER UNSIGNED, ADD payment_profile_id INTEGER UNSIGNED;

#
ALTER TABLE purchase ADD cardLast4 VARCHAR(4);

#######################################################
# Sept 19th 2011
ALTER TABLE purchase CHANGE cardLast4 cardLast4 VARCHAR(8);

#############################################3
# Oct 11th 2011
ALTER TABLE customer ADD cardType VARCHAR(12);

###########################################
# Oct 20th 2011
ALTER TABLE charm ADD popular BOOL DEFAULT FALSE;

############################################
# Nov 9th 2011
ALTER TABLE sample_requests ADD last_name VARCHAR(64);
ALTER TABLE template_requests ADD last_name VARCHAR(64);
ALTER TABLE quote_requests ADD last_name VARCHAR(64);


###############################################
# Jan 12
ALTER TABLE cart_items CHANGE template template VARCHAR(32);
ALTER TABLE order_item ADD template VARCHAR(32);

################################################
ALTER TABLE item_parts CHANGE ribbon_ID ribbon_ID INTEGER;
ALTER TABLE item_parts CHANGE tassel_ID tassel_ID INTEGER;
ALTER TABLE item_parts CHANGE charm_ID charm_ID INTEGER;
ALTER TABLE item_parts CHANGE quote_ID quote_ID INTEGER;
ALTER TABLE item_parts CHANGE border_ID border_ID INTEGER;

ALTER TABLE order_item CHANGE template template VARCHAR(32);

################################
# Feb 15

ALTER TABLE product_type ADD free_shipping BOOL;
UPDATE product_type SET free_shipping = IF(code IN ('MG','MG-USA','PW','PWK','DPWK','DPW','DPW-FLC','DPWK-FLC'), 0, 1);

############################

ALTER TABLE specialty_page_prospects ADD want_account BOOL DEFAULT TRUE;
ALTER TABLE specialty_page_prospects ADD resale_number VARCHAR(64);
ALTER TABLE specialty_page_prospects ADD product_type_id INTEGER UNSIGNED;
ALTER TABLE specialty_page_prospects ADD quantity INTEGER UNSIGNED;


##############################
ALTER TABLE purchase ADD created DATETIME, ADD modified DATETIME;
ALTER TABLE order_item ADD created DATETIME, ADD modified DATETIME;

################################
INSERT INTO part_type SET part_name = 'Background Color', part_code='background', part_title = 'Select a Custom Background Color';
ALTER TABLE item_parts ADD backgroundColor VARCHAR(7);
INSERT INTO product_categories SET name = 'Stamp Products', sort_index = '40';

#####################################
#DROP TABLE IF EXISTS product_descriptions;
CREATE TABLE IF NOT EXISTS product_descriptions
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product_type_id INTEGER UNSIGNED,
	ix INTEGER UNSIGNED,
	with_overview BOOL DEFAULT FALSE,
	title VARCHAR(64),
	content TEXT,
	disabled BOOL DEFAULT FALSE,
	created DATETIME,
	modified DATETIME
);

############################################3
#DROP TABLE IF EXISTS admins;
CREATE TABLE IF NOT EXISTS admins
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(64),
	password VARCHAR(128),
	disabled BOOL DEFAULT FALSE,
	created DATETIME,
	modified DATETIME
);

INSERT INTO admins SET email = 'hdi@earthlink.net' , password = 'f60737146242e7376d673307ad259fca15fa58c0'; # sf6554
INSERT INTO admins SET email = 't_maly@comcast.net' , password = '5c1baa694caf36d6a9825bfa473f167dea16f82d'; # tomas1234
################################################
ALTER TABLE product_type CHANGE made_in_usa made_in_usa ENUM ('manufactured','designed','no');
UPDATE product_type SET made_in_usa = 'designed' WHERE code IN ('MP','TS');
UPDATE product_type SET made_in_usa = 'no' WHERE code IN ('TA');

#########################################################
ALTER TABLE product_type ADD surcharge_YS FLOAT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE product_type ADD surcharge_YM FLOAT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE product_type ADD surcharge_YL FLOAT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE product_type ADD surcharge_YXL FLOAT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE product_type ADD surcharge_S FLOAT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE product_type ADD surcharge_M FLOAT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE product_type ADD surcharge_L FLOAT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE product_type ADD surcharge_XL FLOAT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE product_type ADD surcharge_XXL FLOAT UNSIGNED NOT NULL DEFAULT 0;
ALTER TABLE product_type ADD surcharge_XXXL FLOAT UNSIGNED NOT NULL DEFAULT 0;

############################################################
ALTER TABLE cart_items ADD surcharge FLOAT UNSIGNED NOT NULL;


################################
ALTER TABLE product_features CHANGE text text TEXT;


###############################
#

#####################
ALTER TABLE item_parts ADD personalizationSize ENUM('Small','Medium','Large') DEFAULT 'Large';
ALTER TABLE item_parts ADD textSize ENUM('Small','Medium','Large') DEFAULT 'Large';

############################
#DROP TABLE IF EXISTS coupons;
CREATE TABLE IF NOT EXISTS coupons
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,

	title VARCHAR(64),

	code VARCHAR(24),

	description TEXT,

	percent INTEGER UNSIGNED, #  % off
	amount INTEGER UNSIGNED, # dollar off
	free_shipping BOOL DEFAULT FALSE,

	minimum INTEGER UNSIGNED, # order total required to qualify

	wholesale_only BOOL DEFAULT FALSE,


	start DATETIME,
	end DATETIME,

	day_of_week ENUM('','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'),

	multiple_use BOOL DEFAULT FALSE,

	advertise BOOL DEFAULT FALSE, # on homepage/landing, etc

	active BOOL DEFAULT TRUE,

	# GRAPHIC UPLOAD RELATED STUFF
	path VARCHAR(255),
	filename VARCHAR(255),
	size INTEGER UNSIGNED,
	type VARCHAR(12),
	ext VARCHAR(6),

	created DATETIME,
	modified DATETIME
);

ALTER TABLE purchase ADD coupon VARCHAR(24); # Record so we can check for multiple redemption
ALTER TABLE purchase ADD discount FLOAT UNSIGNED; # How much the coupon took off the subtotal (separate line item)
# May need to cross reference with session or customer_id

#################
ALTER TABLE specialty_page_prospects ADD type VARCHAR(24);

#################
#DROP TABLE IF EXISTS completed_projects;
CREATE TABLE IF NOT EXISTS completed_projects
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	customer_id INTEGER UNSIGNED,
	session_id VARCHAR(128),
	project_reference VARCHAR(48), # po number, title, etc...

	full_name VARCHAR(64),
	email VARCHAR(64),
	phone VARCHAR(24),
	zip_code VARCHAR(12),
	company VARCHAR(64),
	wholesale_customer BOOL DEFAULT FALSE,

	product_type_id INTEGER UNSIGNED,
	quantity INTEGER UNSIGNED,

	#proof ENUM('consult','proof_only', 'proof_order'),
	free_consultation BOOL DEFAULT FALSE,
	free_email_proof BOOL DEFAULT FALSE,
	proof_without_order BOOL DEFAULT FALSE,
	free_quote BOOL DEFAULT FALSE,
	printing_on_back ENUM ('none','same','different') DEFAULT 'none',

	needed_by DATE,
	needed_by_strict BOOL DEFAULT FALSE,
	comments TEXT,

	created DATETIME,
	modified DATETIME
);

#DROP TABLE IF EXISTS completed_images;
CREATE TABLE IF NOT EXISTS completed_images
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	completed_project_id INTEGER UNSIGNED,

	# UPLOAD INFORMATION
	path VARCHAR(255),
	filename VARCHAR(255),
	size INTEGER UNSIGNED,
	type VARCHAR(12),
	ext VARCHAR(6),

	created DATETIME,
	modified DATETIME
);
#######################
# Updating shipping costs:

UPDATE shippingPricePoint SET cost_old = cost, cost = cost*1.05;

#####################
alter table cart_items add picture_only BOOL DEFAULT FALSE;
alter table item_parts add picture_only BOOL DEFAULT FALSE;

#######################
# Allow customImage to use new or old uploading system

ALTER TABLE custom_image ADD path VARCHAR(255), ADD filename VARCHAR(255), ADD size INTEGER UNSIGNED, ADD type VARCHAR(12), ADD ext VARCHAR(6);

#DROP TABLE IF EXISTS purchase_orders;
CREATE TABLE IF NOT EXISTS purchase_orders
(
	id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	completed_project_id INTEGER UNSIGNED,

	# UPLOAD INFORMATION
	path VARCHAR(255),
	filename VARCHAR(255),
	size INTEGER UNSIGNED,
	type VARCHAR(12),
	ext VARCHAR(6),

	created DATETIME,
	modified DATETIME
);
ALTER TABLE specialty_page_prospects ADD purchase_order_id INTEGER UNSIGNED;
ALTER TABLE specialty_page_prospects ADD purchase_order BOOL DEFAULT FALSE;

###########################
ALTER TABLE completed_projects ADD address VARCHAR(64), ADD address_2 VARCHAR(64), ADD city VARCHAR(64), ADD state VARCHAR(32), ADD country VARCHAR(32);


ALTER TABLE specialty_page_prospects ADD phone_extension INTEGER UNSIGNED;

#############################
ALTER TABLE customer ADD resale_number VARCHAR(16);

##############################
ALTER TABLE cart_items ADD parts2 BLOB;


##############################
ALTER TABLE partPricePoint ADD setup_charge FLOAT;

#############################
ALTER TABLE product_type ADD created DATETIME, ADD modified DATETIME;
ALTER TABLE stamp ADD created DATETIME, ADD modified DATETIME;
UPDATE product_type SET modified = now() WHERE modified IS NULL;
UPDATE stamp SET modified = now() WHERE modified IS NULL;


#######################
# New ItemPart stuff for new build.
ALTER TABLE item_parts
	ADD crop_xywh VARCHAR(32),
	ADD quote_attribution VARCHAR(255),
	ADD quote_font VARCHAR(32),
	ADD quote_font_size INTEGER,
	ADD quote_color VARCHAR(6),
	ADD quote_xy VARCHAR(16),
	ADD personalization_font VARCHAR(32),
	ADD personalization_font_size INTEGER,
	ADD personalization_xy VARCHAR(16),
	ADD border1_y INTEGER,
	ADD border2_y INTEGER
;
###########################
ALTER TABLE browse_node ADD page_title VARCHAR(60);
UPDATE browse_node SET page_title = browse_name;


#
ALTER TABLE cart_items ADD new_build BOOL DEFAULT FALSE;
ALTER TABLE order_item ADD new_build BOOL DEFAULT FALSE;

#######################
ALTER TABLE part_type ADD design_tips TEXT;

#######################
ALTER TABLE product_type ADD new_build BOOL DEFAULT FALSE;
