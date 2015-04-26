DROP procedure IF EXISTS `p_hp_page_initdata`;
DELIMITER $$
CREATE PROCEDURE `p_hp_page_initdata` (in currentID bigint)
BEGIN
	
    declare canDo int default 1;
	declare dolevel int default 1;
    SET SQL_SAFE_UPDATES=0;
    /*更新子节点数*/
    update  hp_page as l
		left join  (select count(0) as Items,page_parent from hp_page group by page_parent) as sub on l.id=sub.page_parent
	set l.page_total_child=sub.Items 
	where l.id>0 and sub.items>0;
    
	/*更新节点路径*/
    
	update hp_page set page_path=CONCAT('P','.',LPAD(page_sequence,3, 0)) where ifnull(page_parent,0)<=0 and id>0;    
    if row_count()>0 then
		while canDo=1 and dolevel<20 do	
			update  hp_page as l
				inner join hp_page as p on l.page_parent=p.id
			set l.page_path=CONCAT(p.page_path,'.',LPAD(l.page_sequence,3, 0))
            where length(p.page_path)-length(replace(p.page_path,'.',''))=dolevel;

            if(ROW_COUNT()<=0) then				
				set canDo=0;
            end if;
			if  canDo=1 then
				 select dolevel+1 into dolevel;
			end if;	
		end while;        
	end if;
  
END
$$

DELIMITER ;
DROP procedure IF EXISTS `p_hp_page_getparents`;
DELIMITER $$
CREATE PROCEDURE `p_hp_page_getparents` (in currentID bigint)
BEGIN
	declare parent bigint default currentID;	
    declare canDo int default 1;
    drop temporary table if  EXISTS tmp1;
	create temporary table IF NOT EXISTS tmp1(id bigint)ENGINE=MEMORY DEFAULT CHARSET=utf8;
  
		truncate table tmp1;
        if IFNULL(currentID,0)>0 then
			/*加载当前节点*/
			insert into tmp1(id) select currentID;
            /*加载下级节点*/
			insert into tmp1(id) select id from hp_page where page_parent=currentID;
            /*加载同级节点*/
            insert into tmp1(id) select id from hp_page where page_parent=(select page_parent from hp_page where id=currentID);
        end if;
        
		while IFNULL(parent,0)>0 and canDo=1 do	
            /*查询父节点ID*/
			select page_parent into parent from hp_page where ID=parent and page_parent>0 ;
            if(ROW_COUNT()<=0) then
				set canDo=0;
            end if;
			if  canDo=1 and IFNULL(parent,0)>0 then
				insert into tmp1(id) select parent;
			end if;	
		end while;        
        
        /*加载根节点*/
        insert into tmp1(id) select id from hp_page where page_parent=0;
        
		select distinct l.page_path as Path,length(l.page_path)-length(replace(l.page_path,'.','')) as Level,l.id as ID,l.createdon as CreatedOn,l.createdby as CreatedBy,l.version as Version,l.status as Status
			,l.page_parent as Parent,l.page_title as Title,l.page_navcode as NavCode,l.page_sequence as Sequence
			,l.page_isedit as IsEdit,l.page_iscomment as IsComment,l.page_isassess as IsAssess,l.page_isprivate as IsPrivate
			,l.page_total_child as Total_Child,l.page_total_length as Total_Length,l.page_total_counter as Total_Counter
			,l.page_total_edit as Total_Edit,l.page_total_comment as Total_Comment,l.page_total_assess as Total_Assess
		From hp_page as l 
			inner join tmp1 as f on l.id=f.id
		order by l.page_path;

END
$$

DELIMITER ;

DROP procedure IF EXISTS `p_md_getEntityAttr`;
DELIMITER $$
CREATE PROCEDURE `p_md_getEntityAttr`(in entity nvarchar(100))
BEGIN
	
	declare parent nvarchar(100) default entity;	
	create temporary table IF NOT EXISTS tmp1(id nvarchar(100))ENGINE=MEMORY DEFAULT CHARSET=utf8;

	truncate table tmp1;
	insert into tmp1(id) select entity;
	while length(ifnull(parent,''))>2 do
		select ParentID into parent from MD_Entity where ID=parent;		
		if length(ifnull(parent,''))>2 then
			insert into tmp1(id) select parent;
		end if;		
	end while; 
	Select l.ID,l.Name,l.DisplayName,l.Description,l.GroupName,l.ColumnName,l.DefaultValue
		,l.IsCollection,l.IsKey,l.IsEntityKey,l.IsNullable,l.IsSystem,l.IsBusinessKey
		,d.ID as DataTypeID,d.FullName as DataTypeFullName,d.DisplayName as DataTypeDisplayName,d.ClassType as DataTypeClassType
	From MD_EntityAttribute as l 
		inner join tmp1 as f on l.Entity=f.id
		left Join MD_Entity as d on l.DataTypeID=d.ID 		
	 Order By l.IsSystem Desc,l.Sequence Asc,l.Name;
		
END$$
DELIMITER ;