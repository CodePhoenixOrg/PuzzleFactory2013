CREATE TABLE `applications` (
`app_id` INT NOT NULL,
`di_id` INT NOT NULL
)

CREATE TABLE `block_type` (
`bt_id` INT NOT NULL,
`bt_type` VARCHAR(10) NOT NULL
)

CREATE TABLE `blocks` (
`bl_id` INT NOT NULL,
`bl_column` CHAR(1),
`bt_id` INT NOT NULL,
`di_id` INT NOT NULL
)

CREATE TABLE `bugreport` (
`br_id` INT NOT NULL,
`br_title` CHAR(255),
`br_text` TEXT,
`br_importance` INT,
`br_status` VARCHAR(8),
`br_date` DATE,
`br_time` DATE,
`si_id` INT,
`usr_id` INT
)

CREATE TABLE `changelog` (
`cl_id` INT NOT NULL,
`cl_title` VARCHAR(255),
`cl_TEXT` TEXT,
`cl_date` DATE,
`cl_time` DATE,
`si_id` INT,
`usr_id` INT
)

CREATE TABLE `dbconn` (
`dbc_id` INT NOT NULL,
`dbc_host` VARCHAR(50) NOT NULL,
`dbc_database` VARCHAR(15) NOT NULL,
`dbc_login` VARCHAR(15) NOT NULL,
`dbc_passwd` VARCHAR(16) NOT NULL,
`dbs_id` INT NOT NULL
)

CREATE TABLE `dbserver_type` (
`dbs_id` INT NOT NULL,
`dbs_type` VARCHAR(10) NOT NULL
)

CREATE TABLE `dictionary` (
`di_id` INT NOT NULL,
`di_name` CHAR(8),
`di_fr_short` CHAR(255),
`di_fr_long` TEXT,
`di_en_short` CHAR(255),
`di_en_long` TEXT,
`di_ru_short` CHAR(255),
`di_ru_long` TEXT
)

CREATE TABLE `groups` (
`grp_id` INT NOT NULL,
`grp_name` CHAR(15) NOT NULL,
`grp_members_priv` CHAR(1) NOT NULL,
`grp_menu_priv` CHAR(1) NOT NULL,
`grp_page_priv` CHAR(1) NOT NULL,
`grp_news_priv` CHAR(1) NOT NULL,
`grp_items_priv` CHAR(1) NOT NULL,
`grp_database_priv` CHAR(1) NOT NULL,
`grp_images_priv` CHAR(1) NOT NULL,
`grp_calendar_priv` CHAR(1) NOT NULL,
`grp_newsletter_priv` CHAR(1) NOT NULL,
`grp_forum_priv` CHAR(1) NOT NULL,
`grp_users_priv` CHAR(1) NOT NULL
)

CREATE TABLE `images` (
`im_id` INT NOT NULL,
`im_name` VARCHAR(15) NOT NULL,
`im_dir` VARCHAR(255) NOT NULL,
`im_url` VARCHAR(255) NOT NULL,
`si_id` INT NOT NULL
)

CREATE TABLE `member_newletter` (
`mbr_id` INT,
`nl_id` INT
)

CREATE TABLE `members` (
`mbr_id` INT NOT NULL,
`mbr_name` CHAR(50),
`mbr_adr1` CHAR(50),
`mbr_adr2` CHAR(50),
`mbr_cp` CHAR(5),
`mbr_email` CHAR(50),
`mbr_login` CHAR(50),
`mbr_password` CHAR(50)
)

CREATE TABLE `menus` (
`me_id` INT NOT NULL,
`me_level` CHAR(1),
`me_target` CHAR(7),
`pa_id` INT,
`bl_id` INT
)

CREATE TABLE `newsletter` (
`nl_id` INT NOT NULL,
`nl_title` CHAR(255),
`nl_author` CHAR(255),
`nl_header` TEXT,
`nl_image` CHAR(255),
`nl_comment` CHAR(255),
`nl_body` TEXT,
`nl_links` TEXT,
`nl_footer` TEXT,
`nl_file` CHAR(255),
`nl_date` DATE
)

CREATE TABLE `page_type` (
`pt_id` INT NOT NULL,
`pt_type` CHAR(10) NOT NULL
)

CREATE TABLE `pages` (
`pa_id` INT NOT NULL,
`pa_filename` VARCHAR(255),
`pa_directory` VARCHAR(1024),
`pa_url` VARCHAR(1024),
`di_id` INT NOT NULL,
`pt_id` INT,
`si_id` INT
)

CREATE TABLE `queries` (
`qy_id` INT NOT NULL,
`qy_name` VARCHAR(15) NOT NULL,
`qy_text` TEXT,
`dbc_id` INT NOT NULL
)

CREATE TABLE `servers` (
`se_id` INT NOT NULL,
`se_host` VARCHAR(255) NOT NULL
)
