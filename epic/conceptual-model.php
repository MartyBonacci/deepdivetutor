<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
	</head>
	<body>
		<h1>Conceptual Model</h1>
		<h2>profile</h2>
		<ul>
			<li>profileId (primary key)</li>
			<li>profileName</li>
			<li>profileEmail</li>
			<li>profileType</li>
			<li>profileGithubToken</li>
			<li>profileBio</li>
			<li>profileRate</li>
			<li>profileImage</li>
			<li>profileLastEditDate</li>
			<li>profileActivationToken</li>
			<li>profileHash</li>
			<li>profileSalt</li>
		</ul>
		<br/>
		<h2>review</h2>
		<ul>
			<li>reviewId (primary key)</li>
			<li>reviewStudentProfileId (foreign key)</li>
			<li>reviewTutorProfileId (foreign key)</li>
			<li>reviewRating</li>
			<li>reviewText</li>
			<li>reviewDate</li>
		</ul>
		<br/>
		<h2>skill</h2>
		<ul>
			<li>skillId</li>
			<li>skillName</li>
		</ul>
		<br/>
		<h2>profileSkill</h2>
		<ul>
			<li>profileSkillProfileId (foreign key)</li>
			<li>profileSkillSkillId (foreign key)</li>
		</ul>
		<br/>
		<img src="images/deepdiveturor-erd.svg" alt="erd">
	</body>
</html>