
CREATE TABLE  	agents(	agentId 	VARCHAR(20),
						regDate 	TIMESTAMP, 						 
						lastConn	TIMESTAMP, 
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
						commandDate 	TIMESTAMP , 
						pullNum			INT	,	
						PRIMARY KEY (taskId)
);

CREATE TABLE	serverlog(	event			VARCHAR(80), 
							eventDate		TIMESTAMP, 
							agent			VARCHAR(20), 
							implemntor		VARCHAR(20),
							error			BOOLEAN
); 

CREATE TABLE	permission( username 	VARCHAR(20), 
							password 	VARCHAR(20), 
							PRIMARY KEY (userName)
				
);

CREATE TABLE 	doneTasks(taskId           	BIGINT,
						  kind            	VARCHAR(20),
						  AgentId          	VARCHAR(20),
						  ImplementorId    	VARCHAR(20),
						  commandDate      	TIMESTAMP,
						  submitionDate    	TIMESTAMP,	
						  pullNum			INT	,						  
						  PRIMARY KEY (taskId)

);

CREATE TABLE	failedTasks(
						taskId			BIGINT(20), 
						agentId			varchar(45), 
						implementorId 	varchar(45), 
						failureDate		TIMESTAMP
);

CREATE TABLE	sessions(
						userName		varchar(64), 
						password		varchar(64),
						contime			int, 
						id				varchar(128) 
); 

"INSERT INTO agents  VALUES ('yosi',NOW(),NOW())";


				

