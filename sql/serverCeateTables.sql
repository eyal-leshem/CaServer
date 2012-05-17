
CREATE TABLE  	agents(	agentId 	VARCHAR(20),
						regDate 	TIMESTAMP, 						 
						lastConn	TIMESTAMP
); 

CREATE TABLE  	implementors(	agendId 		VARCHAR(20), 
								implementorId	VARCHAR(20) 
);

CREATE TABLE   	tasks(	taskId			BIGINT,
						dependOn		BIGINT, 
						kind			VARCHAR(20),
						AgentId 		VARCHAR(20), 
						ImplementorId	VARCHAR(20), 
						commandDate 	TIMESTAMP
);

CREATE TABLE	serverlog(	event			VARCHAR(50), 
							eventDate		TIMESTAMP, 
							agent			VARCHAR(20), 
							implemntor		VARCHAR(20),
							error			BOOLEAN
); 

CREATE TABLE	permission( username 	VARCHAR(20), 
							password 	VARCHAR(20)
				
);

"INSERT INTO agents  VALUES ('yosi',NOW(),NOW())";


				

