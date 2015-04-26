SET SQL_SAFE_UPDATES=0;

/*页面*/

truncate table hp_page;

load data local infile  "E:/server/www/u9bang/web/data/hp_page.txt" replace into table hp_page IGNORE 1 LINES (ID,page_parent,page_sequence,page_navcode,page_title);




truncate table MD_AppComponent;
truncate table MD_EntityAttribute;
truncate table MD_Entity;
truncate table MD_UIRefComponent;
truncate table MD_UIReference;

load data local infile "E:/server/www/u9bang/web/data/MD_AppComponent.txt" replace into table MD_AppComponent IGNORE 1 LINES (ID,Name,DisplayName,Description,Type,AssemblyName);
load data local infile "E:/server/www/u9bang/web/data/MD_Entity.txt" replace into table MD_Entity IGNORE 1 LINES (Component,ID,Name,FullName,DisplayName,Description,ParentID,DefaultTable,ClassType,ReturnDataID,ReturnIsCollection,ReturnIsEntityKey) ;
load data local infile "E:/server/www/u9bang/web/data/MD_EntityAttribute.txt" replace into table MD_EntityAttribute IGNORE 1 LINES(ID,Entity,Name,DisplayName,Description,DataTypeID,DefaultValue,ColumnName,GroupName,Sequence,IsCollection,IsKey,IsNullable,IsSystem,IsBusinessKey,IsEntityKey,IsGlobalization);
load data local infile "E:/server/www/u9bang/web/data/MD_UIRefComponent.txt" replace into table MD_UIRefComponent (ID,Name,DisplayName,Description,GroupName,RefType,URI,IsMultiSelect,IsForMultOrg,IsDefault,ClassName,Assembly,Path) ;
load data local infile "E:/server/www/u9bang/web/data/MD_UIReference.txt" replace into table MD_UIReference (Component,ID,Name,DisplayName,Description,RefType,RefEntityID,IsMain,Filter) ;




