import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router"
import {ProfileService} from "../services/profile.service";
import {subscribeOn} from "rxjs/operator/subscribeOn";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";


@Component({
	templateUrl: "./templates/browse.html",
	providers: [ProfileService]
})

export class BrowseComponent implements OnInit {
	tutorProfiles: Profile[] = [];
	profile: Profile = new Profile(null, null, null, null, null, null, null, null, null, null, null, null);
	status: Status = null;

	constructor(private profileService: ProfileService, private router: Router) {
	}

	ngOnInit(): void {
		this.reloadProfiles();
	}

	reloadProfiles(): void {
		this.profileService.getProfileByProfileType(1)
			.subscribe(tutorProfiles => this.tutorProfiles = tutorProfiles);
	}

	switchTutorProfile(tutorProfile: Profile): void {
		this.router.navigate(["/profile/", tutorProfile.profileId]);
	}
}