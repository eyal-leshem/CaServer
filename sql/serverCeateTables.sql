
CREATE TABLE  	agents(	agentId 		VARCHAR(20),
						lastconn		datetime, 
						regDate 		datetime, 						 
						PRIMARY KEY (agentId)
); 

CREATE TABLE  	implementors(	agentId 		VARCHAR(20), 
								implementorId	VARCHAR(20), 
								PRIMARY KEY (agentId, implementorId)
);

CREATE TABLE   	tasks(	taskId			BIGINT,
						dependOn		BIGINT,
						alg				VARCHAR(20), 
						kind			VARCHAR(20),
						AgentId 		VARCHAR(20), 
						ImplementorId	VARCHAR(20), 
						commandDate 	datetime , 
						pullNum			INT	,	
						PRIMARY KEY (taskId)
);

CREATE TABLE	serverlog(	event			VARCHAR(150), 
							eventDate		datetime, 
							agent			VARCHAR(20), 
							implemntor		VARCHAR(20),
							error			BOOLEAN
); 

CREATE TABLE	permission( username 	VARCHAR(20), 
							password 	VARCHAR(80), 
							PRIMARY KEY (userName)
				
);

CREATE TABLE 	doneTasks(taskId           	BIGINT,
						  kind            	VARCHAR(20),
						  AgentId          	VARCHAR(20),
						  ImplementorId    	VARCHAR(20),
						  commandDate      	datetime,
						  submitionDate    	datetime,	
						  pullNum			INT	,						  
						  PRIMARY KEY (taskId)

);

CREATE TABLE	failedTasks(
						taskId			BIGINT(20), 
						agentId			varchar(45), 
						implementorId 	varchar(45), 
						failureDate		datetime
);

CREATE TABLE	plugins(		
			agentId			varchar(45), 
			pluginName		varchar(45)			
);

Create Table    AgentsConf(
					agentId 		varchar(45),
					agentConf		varchar(200) 
); 

Create Table	lowSecureData(
				taskId 		varchar(45),
				aData		varchar(400)
);

create Table	algorithms(
	agentId          varchar(20),

	implementorId    varchar(45),

	algorithm        varchar(45) 
);





				

