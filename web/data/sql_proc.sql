DROP procedure IF EXISTS `p_hp_page_getparents`;

DELIMITER $$
CREATE PROCEDURE `p_hp_page_getparents` (in currentID bigint)
BEGIN
	declare parent bigint default currentID;	
    declare ind int default 0;
	create temporary table IF NOT EXISTS tmp1(id bigint,ind int)ENGINE=MEMORY DEFAULT CHARSET=utf8;
  
		truncate table tmp1;
        if parent>0 then
			insert into tmp1(id,ind) select parent,0;
            /*加载同级节点*/
            insert into tmp1(id,ind) select id,0 from hp_page where page_parent=(select page_parent from hp_page where id=parent);
        end if;
		while parent>0 do			
			select page_parent into parent from hp_page where ID=parent;		
			if  parent>0 then
				select ind+1 into ind;
				insert into tmp1(id,ind) select parent,ind;
			end if;		
		end while;    
        /*加载根节点*/
        insert into tmp1(id,ind) select id,ind from hp_page where page_parent=0;
        
		select distinct ind-f.ind as Level,l.id as ID,l.createdon as CreatedOn,l.createdby as CreatedBy,l.version as Version,l.status as Status
			,l.page_parent as Parent,l.page_title as Title,l.page_navcode as NavCode,l.page_sequence as Sequence
			,l.page_isedit as IsEdit,l.page_iscomment as IsComment,l.page_isassess as IsAssess
			,l.page_total_child as Total_Child,l.page_total_length as Total_Length,l.page_total_counter as Total_Counter
			,l.page_total_edit as Total_Edit,l.page_total_comment as Total_Comment,l.page_total_assess as Total_Assess
		From hp_page as l 
			inner join tmp1 as f on l.id=f.id
		order by f.ind desc,l.id;

END
$$

DELIMITER ;