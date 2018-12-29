CREATE TABLE v_menus
(
    vm_id int( 11 ) NOT NULL AUTO_INCREMENT,
    me_id int( 11 ) NOT NULL default 1,
    pa_id int( 11 ) NOT NULL default 1,
    me_target varchar( 7 ) NOT NULL default 'page',
    me_level char( 1 ) NOT NULL default 1,
    di_name varchar( 8 ) NOT NULL default '',
    pa_filename varchar( 255 ) NOT NULL default '',
    di_fr_short varchar( 50 ) NOT NULL default '',
    di_fr_long text NOT NULL,
    di_en_short varchar( 50 ) NOT NULL default '',
    di_en_long text NOT NULL,
    PRIMARY KEY ( vm_id ),
    UNIQUE KEY vm_id ( vm_id ) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 