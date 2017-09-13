import {Component, ViewChild, OnInit} from "@angular/core";
import {Observable} from "rxjs/Observable"
import {ActivatedRoute, Params, Router} from "@angular/router";
import {Status} from "../classes/status";
import {SkillService} from "../services/skill.service";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {CookieService} from "ng2-cookies";
import {Skill} from "../classes/skill";
import {ImageComponent} from "./image.component";

//declare $ for good old jquery
declare let $: any;

@Component({
	templateUrl: "./templates/profile-edit.html",
	selector: "profile-edit"
})

export class ProfileEditComponent implements OnInit {
	@ViewChild(ImageComponent) imageComponent: ImageComponent;
	profile: Profile = new Profile(null, null, null, null, null, null, null, null, null);
	status: Status = null;
	cookieJar: any = {};
	skills: Skill[] = [];

	constructor(private profileService: ProfileService, private router: Router, private skillService: SkillService, private cookieService: CookieService,private route: ActivatedRoute) {
	}

	ngOnInit() : void {
		this.route.params.forEach((params: Params) => {
			let profileId = +params["profileId"];
			this.cookieJar = this.cookieService.getAll();
			this.profileService.getProfile(profileId)
				.subscribe(profile => this.profile = profile);

		})
	}

	getAllSkillNames(): void {
		this.skillService.getAllSkillNames()
			.subscribe(skills => this.skills = skills);
	}

	createProfileEdit(): void {
		this.profileService.editProfile(this.profile)
			.subscribe(status => this.status = status);

	}
}
