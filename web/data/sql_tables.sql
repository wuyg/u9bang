/*ID*/
Drop Table if exists sys_idlist;
CREATE TABLE if not exists sys_idlist  (
  minid BigInt Default 10000000,
  maxid BigInt Default 0
);
/*
单点用户
用户基本信息（账号，密码，密钥，真实姓名，用户昵称，用户头像，状态，手机号，邮箱）
其它信息（编辑次数）
*/
Drop Table if exists sso_user;
CREATE TABLE sso_user (  
  id bigint unsigned NOT NULL PRIMARY KEY,  
  createdon timestamp  NOT NULL default now() ,
  version int unsigned NOT NULL default 0,
  u_account varchar(255) binary NOT NULL default '',
  u_newpassword tinyblob NOT NULL,
  u_newpasswordtime binary(14),
  u_secretkey varchar(255) binary NOT NULL default '',
  u_password tinyblob NOT NULL,
  u_nickname varchar(255) binary NOT NULL default '',
  u_email tinytext NOT NULL,
  u_status int unsigned default 0 COMMENT '数据状态,0:正常,1:锁定,4:删除'
);
/*单点应用*/
Drop Table if exists sso_app;
CREATE TABLE sso_app (  
  id bigint unsigned NOT NULL PRIMARY KEY,  
 createdon timestamp  NOT NULL default now() ,
  version int unsigned NOT NULL default 0,
  app_key varchar(255) binary NOT NULL default '',
  app_name varchar(255) binary NOT NULL default '',
  app_callbackurl varchar(255) binary NOT NULL default '',
  app_status int unsigned default 0 COMMENT '数据状态,0:正常,1:锁定,4:删除'
);
/*单点用户-站点*/
Drop Table if exists sso_appuser;
CREATE TABLE sso_appuser (  
  id bigint unsigned NOT NULL PRIMARY KEY,
 createdon timestamp  NOT NULL default now() ,
  version int unsigned NOT NULL default 0,
  au_user bigint unsigned NOT NULL,
  au_app bigint unsigned NOT NULL,
  au_islogin int unsigned NOT NULL default 0,
  au_logins int unsigned NOT NULL default 0 COMMENT '登录次数',
  au_status int unsigned default 0 COMMENT '数据状态,0:正常,1:锁定,4:删除'
);
/*单点用户-登录日志*/
Drop Table if exists sso_log;
CREATE TABLE sso_log (  
  id bigint unsigned NOT NULL PRIMARY KEY,
 createdon timestamp  NOT NULL default now() ,
  version int unsigned NOT NULL default 0,
  log_user bigint unsigned NOT NULL,
  log_app bigint unsigned NOT NULL,
  log_title varchar(255) binary NOT NULL default '',
  log_type int unsigned default 0 COMMENT '日志类型,0:登录,1:更新',
  log_message BLOB NULL
);



Drop Table if exists hp_assembly;
CREATE TABLE hp_assembly  (
  id bigint unsigned NOT NULL PRIMARY KEY,
  createdon timestamp  NOT NULL default now() ,
  createdby bigint unsigned,
  version int unsigned NOT NULL default 0,
  ass_name  varchar(255) binary NOT NULL default '',
  ass_title varchar(255) binary NOT NULL default '',
  ass_path  varchar(255) binary NOT NULL default '',
  ass_param varchar(255) binary NOT NULL default '',
  ass_description varchar(255) binary NOT NULL default '',
  ass_authority int unsigned DEFAULT 0 COMMENT '权限类型,0:公开,1:登录用户,２:自己'
);


/*节点信息*/
Drop Table if exists hp_page;
CREATE TABLE hp_page (
  id bigint unsigned NOT NULL PRIMARY KEY,
  createdon timestamp  NOT NULL default now() ,
  createdby bigint unsigned,
  version int unsigned NOT NULL default 0,
  status int unsigned default 0 COMMENT '数据状态,0:正常,1:锁定',  
  page_parent bigint unsigned NOT NULL default '0',
  page_title varchar(500) binary NOT NULL,
  page_navcode varchar(500) binary NULL,
  page_content mediumblob NOT NULL,
  page_sequence int unsigned NOT NULL default '0',
  
  page_isedit tinyint unsigned NOT NULL default 0,
  page_iscomment tinyint unsigned NOT NULL default 0,
  page_isassess tinyint unsigned NOT NULL default 0,
  page_private tinyint  unsigned NOT NULL default '0',
  
  page_total_edit int unsigned NOT NULL default 0,
  page_total_comment int unsigned NOT NULL default 0,
  page_total_assess int unsigned NOT NULL default 0,
  page_total_child int unsigned NOT NULL default 0,
  page_total_length int unsigned NOT NULL default 0,
  page_total_counter int unsigned NOT NULL default 0  
 
);
CREATE INDEX index_parent ON hp_page (page_parent);

/*上传文件信息*/
Drop Table if exists hp_upload;
CREATE TABLE hp_upload (
 id bigint unsigned NOT NULL PRIMARY KEY,
  createdon timestamp  NOT NULL default now() ,
  createdby bigint unsigned,
  version int unsigned NOT NULL default 0,
  us_orig_path varchar(255) NOT NULL,
  us_path varchar(255) NOT NULL,
  us_source_type varchar(50),
  us_timestamp varbinary(14) NOT NULL,
  us_status varchar(50) NOT NULL,
  us_props blob,
  us_size int unsigned NOT NULL,
  us_sha1 varchar(31) NOT NULL,
  us_mime varchar(255),
  us_media_type ENUM("UNKNOWN", "BITMAP", "DRAWING", "AUDIO", "VIDEO", "MULTIMEDIA", "OFFICE", "TEXT", "EXECUTABLE", "ARCHIVE") default NULL,
  us_image_width int unsigned,
  us_image_height int unsigned,
  us_image_bits smallint unsigned
);

