-- purge tables
-- drop tables in reverse order
DROP TABLE IF EXISTS profileSkill;
DROP TABLE IF EXISTS skill;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS profile;

-- create tables
CREATE TABLE profile (
	-- NOT NULL means they are required
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileName VARCHAR(50) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	-- true is 1 false is 0
	profileType BIT DEFAULT 1 NOT NULL,
	-- profileGithubToken
	profileBio VARCHAR(500) NOT NULL,
	profileRate INT UNSIGNED NOT NULL,
	-- not sure if image is right
	profileImage BLOB NULL,
	profileLastEditDate DATETIME(6) NOT NULL,
	profileActivationToken CHAR(32) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	UNIQUE (profileEmail),
	PRIMARY KEY (profileId)
);