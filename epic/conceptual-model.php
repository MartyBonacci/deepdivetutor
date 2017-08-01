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
			<li>profilePhoto</li>
			<li>profileStudent (boolean true = student  :  false = tutor)</li>
			<li>profileTopicsOfExperties</li>
			<li>profileEducationAndExperience</li>
			<li>profileHourlyRate</li>
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
	</body>
</html>